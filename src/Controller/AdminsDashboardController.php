<?php
namespace App\Controller;

use Cake\I18n\FrozenTime;

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

        // DATA UNTUK PIE CHART (Status Kereta)
        $carStatusData = [
            'Available' => $carsTable->find()->where(['availability_status' => 'Available'])->count(),
            'Rented' => $carsTable->find()->where(['availability_status' => 'Rented'])->count(),
            'Maintenance' => $carsTable->find()->where(['availability_status' => 'Maintenance'])->count(),
        ];

        // DATA UNTUK BAR CHART (Tempahan 6 Bulan Terkini)
        $monthlyLabels = [];
        $monthlyData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = new FrozenTime("-$i months");
            $monthlyLabels[] = $date->format('M Y'); // Contoh: "Jul 2026"
            
            $start = $date->startOfMonth()->format('Y-m-d 00:00:00');
            $end = $date->endOfMonth()->format('Y-m-d 23:59:59');
            
            $monthlyData[] = $bookingsTable->find()
                ->where(['created >=' => $start, 'created <=' => $end])
                ->count();
        }

        $recentBookings = $bookingsTable->find()
            ->contain(['Customers', 'Cars'])
            ->order(['Bookings.id' => 'DESC'])
            ->limit(5)
            ->all();

        $this->set(compact('totalCars', 'totalCustomers', 'totalBookings', 'todayBookings', 'recentBookings', 'carStatusData', 'monthlyLabels', 'monthlyData'));
        $this->set('pageTitle', 'Dashboard Overview');
    }
}