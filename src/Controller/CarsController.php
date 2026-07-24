<?php
declare(strict_types=1);

namespace App\Controller;

class CarsController extends AppController
{ // <-- Ini kurungan pada line 7 yang sistem beritahu

    // ... fungsi lain (index, view, add, edit, delete, browse) kekal sama ...


   public function search() 
    {
        $this->viewBuilder()->setLayout('default');

        // 1. Ambil 'car_category' dan tarikh dari URL
        $selectedClass = $this->request->getQuery('car_category'); 
        $pickupDate = $this->request->getQuery('pickup_date') ?? $this->request->getQuery('start_date');
        $returnDate = $this->request->getQuery('return_date') ?? $this->request->getQuery('end_date');

        $query = $this->Cars->find('all');
        
        // 2. Filter jika data ada dan bukan 'all'
        if (!empty($selectedClass) && $selectedClass !== 'all') {
            $query->where(['car_category' => $selectedClass]);
        }
        
        $cars = $query->all();

        // 3. LOGIK BARU: Semak kereta yang telah ditempah pada tarikh tersebut (+ 30 Minit Buffer)
        $bookedCarIds = [];
        if (!empty($pickupDate) && !empty($returnDate)) {
            $start = clone new \Cake\I18n\DateTime($pickupDate);
            $end = clone new \Cake\I18n\DateTime($returnDate);
            
            $startBuffer = (clone $start)->modify('-30 minutes');
            $endBuffer = (clone $end)->modify('+30 minutes');
            
            $bookingsTable = $this->fetchTable('Bookings');
            $overlappingBookings = $bookingsTable->find()
                ->select(['car_id'])
                ->where([
                    'booking_status IN' => ['Pending Payment', 'Confirmed', 'Approved', 'Active'],
                    'start_date <' => $endBuffer,
                    'end_date >' => $startBuffer
                ])
                ->all();
            
            foreach ($overlappingBookings as $booking) {
                $bookedCarIds[] = $booking->car_id;
            }
        }
        
        // Hantar $bookedCarIds ke view supaya sistem tahu kereta mana nak dikelabukan
        $this->set(compact('cars', 'bookedCarIds'));
    }
} 