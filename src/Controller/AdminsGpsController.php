<?php
namespace App\Controller;

class AdminsGpsController extends AppController
{
    public function index()
    {
        $carsTable = $this->fetchTable('Cars');
        
        $allCars = $carsTable->find()->all();
        $totalCars = $allCars->count();
        $availableCars = 0;
        $rentedCars = 0;
        $maintenanceCars = 0;
        
        foreach ($allCars as $c) {
            $status = strtolower($c->availability_status);
            if (strpos($status, 'available') !== false) {
                $availableCars++;
            } elseif (strpos($status, 'rent') !== false) {
                $rentedCars++;
            } elseif (strpos($status, 'maintenance') !== false) {
                $maintenanceCars++;
            }
        }

        $cars = $carsTable->find()
            ->where(['latitude IS NOT' => null, 'longitude IS NOT' => null])
            ->all();
            
        foreach ($cars as $car) {
            if (strtolower($car->availability_status) === 'available') {
                $car->latitude = '3.068600';
                $car->longitude = '101.490400';
            }
        }

        $this->set(compact('cars', 'totalCars', 'availableCars', 'rentedCars', 'maintenanceCars'));
        $this->set('pageTitle', 'Live GPS Tracking');
    }
}