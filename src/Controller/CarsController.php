<?php
declare(strict_types=1);

namespace App\Controller;

class CarsController extends AppController
{ // <-- Ini kurungan pada line 7 yang sistem beritahu

    // ... fungsi lain (index, view, add, edit, delete, browse) kekal sama ...

   public function search() 
   {
        $this->viewBuilder()->setLayout('default');

        // 1. Ambil 'car_category' dari URL (SAMA dengan nama input di dashboard)
        $selectedClass = $this->request->getQuery('car_category'); 

        $query = $this->Cars->find('all');
        
        // 2. Filter jika data ada dan bukan 'all'
        if (!empty($selectedClass) && $selectedClass !== 'all') {
            $query->where(['car_category' => $selectedClass]);
        }
        
        $cars = $query->all();
        
        $this->set(compact('cars'));
    }
} 