<?php
namespace App\Controller;

class AdminsDashboardController extends AppController
{
    public function index()
    {
        $carsTable = $this->fetchTable('Cars');
        $bookingsTable = $this->fetchTable('Bookings');
        $customersTable = $this->fetchTable('Customers');

        $totalCars = $carsTable->find()->count();
        $totalCustomers = $customersTable->find()->count();
        $totalBookings = $bookingsTable->find()->count();
        
        $todayBookings = $bookingsTable->find()
            ->where(['created >=' => date('Y-m-d 00:00:00')])
            ->count();

        $recentBookings = $bookingsTable->find()
            ->contain(['Customers', 'Cars'])
            ->order(['Bookings.id' => 'DESC'])
            ->limit(5)
            ->all();

        $this->set(compact('totalCars', 'totalCustomers', 'totalBookings', 'todayBookings', 'recentBookings'));
        $this->set('pageTitle', 'Dashboard Overview');
    }
}