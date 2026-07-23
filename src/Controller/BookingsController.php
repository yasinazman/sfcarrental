<?php
declare(strict_types=1);

namespace App\Controller;

class BookingsController extends AppController
{
    public function add($carId = null)
    {
        // 1. Dapatkan data customer yang sedang login dari session
        $customerSession = $this->request->getSession()->read('Auth.Customer');
        if (!$customerSession) {
            $this->Flash->error(__('Please log in to make a reservation.'));
            return $this->redirect(['controller' => 'Customers', 'action' => 'login']);
        }

        $booking = $this->Bookings->newEmptyEntity();
        $car = $this->Bookings->Cars->get($carId);

        // Ambil semua data dari query string (URL)
        $startDate = $this->request->getQuery('start_date');
        $endDate = $this->request->getQuery('end_date');
        $destination = $this->request->getQuery('destination');
        $pickupLocation = $this->request->getQuery('pickup_location');
        $dropoffLocation = $this->request->getQuery('dropoff_location');

        // Kiraan awal hari dan harga
        $totalDays = 0;
        $totalPrice = 0;
        if ($startDate && $endDate) {
            $start = new \Cake\I18n\DateTime($startDate);
            $end = new \Cake\I18n\DateTime($endDate);
            $diff = $start->diff($end);
            $totalDays = ($diff->days < 1) ? 1 : $diff->days;
            $totalPrice = $totalDays * (float)$car->daily_rate;
        }

        // APABILA BUTANG "CONFIRM & PROCEED TO PAYMENT" DITEKAN
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Cantumkan data dari form dengan data sistem
            $data['customer_id'] = $customerSession['id'];
            $data['total_price'] = $totalPrice;
            $data['rental_price'] = $car->daily_rate;
            $data['booking_status'] = 'Pending Payment';
            $data['deposit_status'] = 'Pending';
            
            // Tarikh mungkin tidak dihantar melalui POST, jadi kita paksa guna data GET tadi
            $data['start_date'] = $startDate;
            $data['end_date'] = $endDate;

            $booking = $this->Bookings->patchEntity($booking, $data);

            // Jika tempahan berjaya disimpan dalam database
            if ($this->Bookings->save($booking)) {
                
                // HOLD KERETA SEMENTARA (Elak double booking dalam masa 5 minit)
                $car->availability_status = 'On Rent'; 
                $this->Bookings->Cars->save($car);
                
                // --- INTEGRASI TOYYIBPAY BERMULA DI SINI ---
                $amountToPay = (float)$data['deposit_amount'] * 100;

                $toyyibpayData = [
                    'userSecretKey' => '969aa7r5-28of-2eje-7wfn-i4l0r000ujlm', // Secret Key Sandbox Anda
                    'categoryCode' => '20onxmn8', // Category Code Sandbox Anda
                    'billName' => 'Deposit Tempahan Kereta',
                    'billDescription' => 'Tempahan untuk ' . $car->car_model . ' selama ' . $totalDays . ' hari.',
                    'billPriceSetting' => 1,
                    'billPayorInfo' => 1,
                    'billAmount' => $amountToPay,
                    'billReturnUrl' => \Cake\Routing\Router::url(['controller' => 'Bookings', 'action' => 'paymentReturn'], true),
                    'billCallbackUrl' => \Cake\Routing\Router::url(['controller' => 'Bookings', 'action' => 'paymentCallback'], true),
                    'billExternalReferenceNo' => $booking->id,
                    'billTo' => $customerSession['full_name'], 
                    'billEmail' => $customerSession['email'] ?? 'tiada@email.com',
                    'billPhone' => $customerSession['phone_number'],
                    'billSplitPayment' => 0,
                    'billSplitPaymentArgs' => '',
                    'billPaymentChannel' => '0', 
                    'billContentEmail' => 'Thank you for your booking with SF Car Rental.',
                    'billChargeToCustomer' => 1, 
                ];

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/createBill');  
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $toyyibpayData);

                $result = curl_exec($curl);
                curl_close($curl);

                $obj = json_decode($result);

                if (isset($obj[0]->BillCode)) {
                    $billCode = $obj[0]->BillCode;
                    $booking->bill_code = $billCode;
                    $this->Bookings->save($booking);
                    
                    $this->Flash->success(__('Booking successful. Please proceed with payment.'));
                    return $this->redirect('https://dev.toyyibpay.com/' . $billCode);
                } else {
                    $this->Flash->error(__('The system failed to generate the payment bill. Please contact the admin.'));
                }
            } else {
                $this->Flash->error(__('Sorry, the order failed to process. Please try again.'));
            }
        }

        // Set data dari URL ke dalam entiti supaya borang auto-isi
        $booking->start_date = $startDate;
        $booking->end_date = $endDate;
        $booking->destination = $destination;
        $booking->pickup_location = $pickupLocation;
        $booking->dropoff_location = $dropoffLocation;

        $this->set(compact('booking', 'car', 'totalDays', 'totalPrice'));
    }
    
    /**
     * FUNGSI 1: URL Return (Untuk Pelanggan)
     * Selepas pelanggan bayar di ToyyibPay, mereka akan landing di sini.
     */
    public function paymentReturn()
    {
        // Dapatkan data yang dipulangkan oleh ToyyibPay di URL
        $statusId = $this->request->getQuery('status_id');
        $orderId = $this->request->getQuery('order_id'); // ID dari jadual bookings
        $billCode = $this->request->getQuery('billcode');
        $transactionId = $this->request->getQuery('transaction_id');

        if ($orderId) {
            $booking = $this->Bookings->get($orderId);

            if ($statusId == 1) {
                // 1. Kemaskini status Tempahan
                $booking->deposit_status = 'Paid';
                $booking->booking_status = 'Confirmed';
                $this->Bookings->save($booking);

                // 2. SIMPAN REKOD KE JADUAL PAYMENTS
                $paymentsTable = $this->fetchTable('Payments');
                
                // Semak jika rekod bayaran untuk booking ini sudah wujud (elak duplicate)
                $payment = $paymentsTable->find()->where(['booking_id' => $orderId])->first();
                if (!$payment) {
                    $payment = $paymentsTable->newEmptyEntity();
                }

                $payment->booking_id = $booking->id;
                $payment->payment_method = 'ToyyibPay (FPX)';
                $payment->payment_status = 'Paid';
                // Ambil nilai deposit dari booking, jika tiada ambil total_price
                $payment->total_payment = $booking->deposit_amount ?? $booking->total_price; 
                $payment->payment_time = new \Cake\I18n\DateTime();

                if ($paymentsTable->save($payment)) {
                    $this->Flash->success(__('Deposit payment successful! Your booking has been confirmed.'));

                    // 3. REDIRECT TERUS KE HALAMAN RESIT (payments/view.php)
                    return $this->redirect(['controller' => 'Payments', 'action' => 'view', $payment->id]);
                }
                
            } elseif ($statusId == 3) {
                // Status 3 = Gagal / Batal
                $booking->deposit_status = 'Failed';
                $booking->booking_status = 'Payment Failed';
                $this->Bookings->save($booking);
                
                $this->Flash->error(__('Payment cancelled or failed. Please try again.'));
            } else {
                $this->Flash->warning(__('Your payment status is being processed.'));
            }
        }

        // Jika gagal atau tiada orderId, hantar pelanggan kembali ke dashboard
        return $this->redirect(['controller' => 'Customers', 'action' => 'dashboard']);
    }

    /**
     * FUNGSI 2: Callback (Untuk Server ToyyibPay)
     * ToyyibPay akan hit URL ini di belakang tabir untuk double confirm status bayaran.
     */
    public function paymentCallback()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->disableAutoLayout();
        
        $statusId = $this->request->getData('status_id');
        $orderId = $this->request->getData('order_id');

        if ($orderId && $statusId == 1) {
            $booking = $this->Bookings->get($orderId);
            $booking->deposit_status = 'Paid';
            $booking->booking_status = 'Confirmed';
            $this->Bookings->save($booking);

            // Simpan juga ke jadual Payments jika belum ada
            $paymentsTable = $this->fetchTable('Payments');
            $payment = $paymentsTable->find()->where(['booking_id' => $orderId])->first();
            if (!$payment) {
                $payment = $paymentsTable->newEmptyEntity();
                $payment->booking_id = $booking->id;
                $payment->payment_method = 'ToyyibPay (FPX)';
                $payment->payment_status = 'Paid';
                $payment->total_payment = $booking->deposit_amount ?? $booking->total_price;
                $payment->payment_time = new \Cake\I18n\DateTime();
                $paymentsTable->save($payment);
            }
        }

        return $this->response->withStringBody('OK');
    }
}