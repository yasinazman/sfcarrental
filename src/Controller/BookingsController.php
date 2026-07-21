<?php
declare(strict_types=1);

namespace App\Controller;

class BookingsController extends AppController
{
    public function add($carId = null)
    {
        $customer = $this->request->getSession()->read('Auth.Customer');
        if (!$customer) {
            $this->Flash->error(__('Sila log masuk.'));
            return $this->redirect(['controller' => 'Customers', 'action' => 'login']);
        }

        $booking = $this->Bookings->newEmptyEntity();
        $car = $this->Bookings->Cars->get($carId);

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Kira hari
            $start = new \Cake\I18n\DateTime($data['start_date']);
            $end = new \Cake\I18n\DateTime($data['end_date']);
            $diff = $start->diff($end);
            $days = ($diff->days < 1) ? 1 : $diff->days;
            
            // Kira jumlah harga
            $total = $days * $car->daily_rate;

            $booking = $this->Bookings->patchEntity($booking, $data);
            $booking->customer_id = $customer['id'];
            $booking->car_id = $carId;
            
            // Update kedua-dua field untuk elakkan validation error
            $booking->rental_price = $total; 
            $booking->total_price = $total; 
            
            $booking->booking_status = 'Pending Payment';

            if ($this->Bookings->save($booking)) {
                // HOLD KERETA SEMENTARA (Elak double booking dalam masa 5 minit)
                $car->availability_status = 'On Rent'; 
                $this->Bookings->Cars->save($car);

                $this->Flash->success(__('Tempahan berjaya. Sila teruskan dengan pembayaran. Masa 5 minit diberikan.'));
                return $this->redirect(['controller' => 'Payments', 'action' => 'process', $booking->id]);
            }
            $this->Flash->error(__('Gagal menyimpan tempahan. Sila cuba lagi.'));
        }

        // Set default dari URL
        $booking->start_date = $this->request->getQuery('start_date');
        $booking->end_date = $this->request->getQuery('end_date');

        $this->set(compact('booking', 'car'));
    }
}