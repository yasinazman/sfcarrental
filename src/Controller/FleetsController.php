<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Event\EventInterface; // Wajib tambah ini untuk menggunakan beforeFilter

class FleetsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Membenarkan pelawat awam melihat halaman senarai kenderaan tanpa log masuk
        $this->Authentication->addUnauthenticatedActions(['index']);
    }

   public function index()
    {
        // Panggil jadual Cars
        $carsTable = TableRegistry::getTableLocator()->get('Cars');

        // 1. Ambil nilai 'car_type' dari URL (dihantar dari borang)
        $carType = $this->request->getQuery('car_type', 'all');

        // 2. Sediakan query asas menggunakan $carsTable
        $query = $carsTable->find();

        // 3. Filter berdasarkan jenis jika bukan 'all'
        if ($carType !== 'all' && !empty($carType)) {
            // TUKAR 'category' kepada 'car_category' 
            $query->where(['car_category' => $carType]);
        }

        // 4. Dapatkan data
        $cars = $query->all();

        // 5. Hantar data ke template
        $this->set(compact('cars', 'carType'));
    }
}