<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry; // Tambahkan baris ini di bahagian atas

class FleetsController extends AppController
{
    public function index()
    {
        // Gantikan $this->loadModel('Cars') dengan cara ini:
        $carsTable = TableRegistry::getTableLocator()->get('Cars');

        // 1. Ambil nilai 'car_type' dari URL
        $carType = $this->request->getQuery('car_type', 'all');

        // 2. Sediakan query asas menggunakan $carsTable
        $query = $carsTable->find();

        // 3. Filter berdasarkan jenis jika bukan 'all'
        if ($carType !== 'all') {
            $query->where(['category' => $carType]);
        }

        // 4. Dapatkan data
        $cars = $query->all();

        // 5. Hantar data ke template
        $this->set(compact('cars', 'carType'));
    }
}