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

        // Kiraan awal hari, harga dan SEMAKAN DOUBLE BOOKING
        $totalDays = 0;
        $totalPrice = 0;
        if ($startDate && $endDate) {
            $start = clone new \Cake\I18n\DateTime($startDate);
            $end = clone new \Cake\I18n\DateTime($endDate);
            
            // Tambah buffer masa 30 minit 
            $startBuffer = (clone $start)->modify('-30 minutes');
            $endBuffer = (clone $end)->modify('+30 minutes');
            
            // Semak jika ada tempahan lain yang bertindih dengan tarikh ini (+ buffer)
            $overlap = $this->Bookings->find()
                ->where([
                    'car_id' => $carId,
                    'booking_status IN' => ['Pending Payment', 'Confirmed', 'Approved', 'Active'],
                    'start_date <' => $endBuffer,
                    'end_date >' => $startBuffer
                ])->first();

            if ($overlap) {
                $this->Flash->error(__('Sorry, this car is already booked or under maintenance for the selected time. Please allow a 30-minute buffer.'));
                return $this->redirect($this->referer());
            }

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
            
            // Kita kekalkan column ini di database jika ada, tetapi biarkan 'Pending'
            $data['deposit_status'] = 'Pending';
            
            $data['start_date'] = $startDate;
            $data['end_date'] = $endDate;
            
            $data['destination'] = $destination;
            $data['pickup_location'] = $pickupLocation;
            $data['dropoff_location'] = $dropoffLocation;

            $booking = $this->Bookings->patchEntity($booking, $data);

            // Jika tempahan berjaya disimpan dalam database
            if ($this->Bookings->save($booking)) {
                
                // --- INTEGRASI TOYYIBPAY BERMULA DI SINI ---
                
                // HANTAR TOTAL PRICE UNTUK BAYARAN PENUH (Darab 100 untuk tukar ke sen)
                $amountToPay = (float)$totalPrice * 100;

                $toyyibpayData = [
                    'userSecretKey' => '969aa7r5-28of-2eje-7wfn-i4l0r000ujlm', // Secret Key Sandbox Anda
                    'categoryCode' => '20onxmn8', // Category Code Sandbox Anda
                    'billName' => 'Bayaran Penuh Tempahan Kereta',
                    'billDescription' => 'Tempahan Penuh untuk ' . $car->car_model . ' selama ' . $totalDays . ' hari.',
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
                    'billContentEmail' => 'Thank you for your full payment booking with SF Car Rental.',
                    'billChargeToCustomer' => 1, 
                ];

                // Menggunakan sistem HTTP Client rasmi CakePHP
                $http = new \Cake\Http\Client();
                $response = $http->post('https://dev.toyyibpay.com/index.php/api/createBill', $toyyibpayData);
                $result = $response->getStringBody();

                $obj = json_decode($result);

                if (isset($obj[0]->BillCode)) {
                    $billCode = $obj[0]->BillCode;
                    $booking->bill_code = $billCode;
                    $this->Bookings->save($booking);
                    
                    $this->Flash->success(__('Booking successful. Please proceed with full payment.'));
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
     */
    public function paymentReturn()
    {
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
                
                $payment = $paymentsTable->find()->where(['booking_id' => $orderId])->first();
                if (!$payment) {
                    $payment = $paymentsTable->newEmptyEntity();
                }

                $payment->booking_id = $booking->id;
                $payment->payment_method = 'ToyyibPay (FPX)';
                $payment->payment_status = 'Paid';
                
                // Ambil nilai bayaran penuh
                $payment->total_payment = $booking->total_price; 
                $payment->payment_time = new \Cake\I18n\DateTime();

                if ($paymentsTable->save($payment)) {
                    $this->Flash->success(__('Full payment successful! Your booking has been confirmed.'));

                    // 3. REDIRECT TERUS KE HALAMAN RESIT (payments/view.php)
                    return $this->redirect(['controller' => 'Payments', 'action' => 'view', $payment->id]);
                }
                
            } elseif ($statusId == 3) {
                $booking->deposit_status = 'Failed';
                $booking->booking_status = 'Payment Failed';
                $this->Bookings->save($booking);
                
                $this->Flash->error(__('Payment cancelled or failed. Please try again.'));
            } else {
                $this->Flash->warning(__('Your payment status is being processed.'));
            }
        }

        return $this->redirect(['controller' => 'Customers', 'action' => 'dashboard']);
    }

    /**
     * FUNGSI 2: Callback (Untuk Server ToyyibPay)
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

            $paymentsTable = $this->fetchTable('Payments');
            $payment = $paymentsTable->find()->where(['booking_id' => $orderId])->first();
            if (!$payment) {
                $payment = $paymentsTable->newEmptyEntity();
                $payment->booking_id = $booking->id;
                $payment->payment_method = 'ToyyibPay (FPX)';
                $payment->payment_status = 'Paid';
                
                // Ambil nilai bayaran penuh
                $payment->total_payment = $booking->total_price;
                
                $payment->payment_time = new \Cake\I18n\DateTime();
                $paymentsTable->save($payment);
            }
        }

        return $this->response->withStringBody('OK');
    }

    public function extend($id = null)
    {
        $booking = $this->Bookings->get($id, [
            'contain' => ['Cars']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $newEndDate = $this->request->getData('new_end_date');
            
            // 1. Dapatkan objek DateTime untuk tarikh asal dan tarikh baru
            $oldEnd = clone $booking->end_date; 
            $newEnd = new \Cake\I18n\DateTime($newEndDate);

            // =========================================================================
            // LOGIK BARU: SEMAK KETERSEDIAAN KERETA (ELAK DOUBLE BOOKING MASA EXTEND)
            // =========================================================================
            $newEndBuffer = (clone $newEnd)->modify('+30 minutes');

            $conflictCount = $this->Bookings->find()
                ->where([
                    'car_id' => $booking->car_id, 
                    'id !=' => $booking->id,      
                    'booking_status IN' => ['Confirmed', 'Pending Payment', 'Approved', 'Active'], 
                    'start_date <' => $newEndBuffer,
                    'end_date >' => $oldEnd->format('Y-m-d H:i:s') 
                ])
                ->count();

            if ($conflictCount > 0) {
                $this->Flash->error(__('Maaf, kereta ini telah ditempah oleh pelanggan lain pada tarikh lanjutan tersebut. Sila pulangkan mengikut jadual asal.'));
                return $this->redirect($this->referer()); 
            }
            // =========================================================================

            // 2. Kira perbezaan hari
            $diff = $oldEnd->diff($newEnd);
            $extraDays = $diff->days;

            if ($extraDays > 0) {
                $extraPrice = $extraDays * (float)$booking->rental_price;

                // 3. Simpan data extension sementara dalam Session (elak customer tipu URL)
                $this->request->getSession()->write("Extension.{$booking->id}", [
                    'new_end_date' => $newEndDate,
                    'extra_price' => $extraPrice,
                    'extra_days' => $extraDays
                ]);

                // 4. Buka Bil ToyyibPay Baru untuk Extension
                $amountToPay = $extraPrice * 100; // tukar ke sen
                $customerSession = $this->request->getSession()->read('Auth.Customer');

                $toyyibpayData = [
                    'userSecretKey' => '969aa7r5-28of-2eje-7wfn-i4l0r000ujlm', // Guna kunci rahsia anda
                    'categoryCode' => '20onxmn8',
                    'billName' => 'Extension Sewa Kereta',
                    'billDescription' => 'Tambah masa sewa untuk ' . $booking->car->car_model . ' selama ' . $extraDays . ' hari lagi.',
                    'billPriceSetting' => 1,
                    'billPayorInfo' => 1,
                    'billAmount' => $amountToPay,
                    'billReturnUrl' => \Cake\Routing\Router::url(['controller' => 'Bookings', 'action' => 'extendReturn'], true),
                    'billExternalReferenceNo' => 'EXT-' . $booking->id,
                    'billTo' => $customerSession['full_name'], 
                    'billEmail' => $customerSession['email'] ?? 'tiada@email.com',
                    'billPhone' => $customerSession['phone_number'],
                    'billSplitPayment' => 0,
                    'billPaymentChannel' => '0', 
                    'billChargeToCustomer' => 1, 
                ];

                // Menggunakan sistem HTTP Client rasmi CakePHP
                $http = new \Cake\Http\Client();
                $response = $http->post('https://dev.toyyibpay.com/index.php/api/createBill', $toyyibpayData);
                $result = $response->getStringBody();

                $obj = json_decode($result);

                if (isset($obj[0]->BillCode)) {
                    $billCode = $obj[0]->BillCode;
                    return $this->redirect('https://dev.toyyibpay.com/' . $billCode);
                } else {
                    $this->Flash->error(__('Gagal menjana bil ToyyibPay untuk extension ini.'));
                }
            } else {
                $this->Flash->error(__('Tarikh baru mestilah selepas tarikh tamat asal.'));
            }
        }

        $this->set(compact('booking'));
    }

    public function extendReturn()
    {
        $statusId = $this->request->getQuery('status_id');
        $refNo = $this->request->getQuery('transaction_id'); 
        $externalRef = $this->request->getQuery('order_id'); // Format: EXT-12

        if ($externalRef && strpos($externalRef, 'EXT-') !== false) {
            $bookingId = str_replace('EXT-', '', $externalRef);
            $booking = $this->Bookings->get($bookingId);

            if ($statusId == 1) {
                // 1. Ambil data sementara dari Session
                $extData = $this->request->getSession()->read("Extension.{$booking->id}");

                if ($extData) {
                    // 2. Kemaskini Jadual Bookings
                    $booking->end_date = new \Cake\I18n\DateTime($extData['new_end_date']);
                    $booking->total_price = $booking->total_price + $extData['extra_price'];
                    $this->Bookings->save($booking);

                    // 3. Tambah rekod bayaran baru ke dalam jadual Payments
                    $paymentsTable = $this->fetchTable('Payments');
                    $payment = $paymentsTable->newEmptyEntity();
                    $payment->booking_id = $booking->id;
                    $payment->payment_method = 'ToyyibPay - Extension';
                    $payment->payment_status = 'Paid';
                    $payment->total_payment = $extData['extra_price']; 
                    $payment->payment_time = new \Cake\I18n\DateTime();
                    $paymentsTable->save($payment);

                    // 4. Buang Session supaya tak berulang
                    $this->request->getSession()->delete("Extension.{$booking->id}");

                    $this->Flash->success(__('Berjaya! Masa sewa anda telah dilanjutkan.'));
                    return $this->redirect(['controller' => 'Customers', 'action' => 'dashboard']);
                }
            } else {
                $this->Flash->error(__('Bayaran extension dibatalkan. Masa sewa kekal asal.'));
            }
        }
        return $this->redirect(['controller' => 'Customers', 'action' => 'dashboard']);
    }
}