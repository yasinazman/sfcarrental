<?php
namespace App\Controller;

class AdminsGpsController extends AppController
{
    public function index()
    {
        $carsTable = $this->fetchTable('Cars');
        
        // Tarik kereta yang ada koordinat GPS sahaja
        $cars = $carsTable->find()
            ->where(['latitude IS NOT' => null, 'longitude IS NOT' => null])
            ->all();

        $this->set(compact('cars'));
        $this->set('pageTitle', 'Live GPS Tracking');
    }
}