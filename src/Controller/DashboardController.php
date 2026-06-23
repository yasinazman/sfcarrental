<?php
namespace App\Controller;

class DashboardController extends AppController
{
    public function index()
    {
        // Di sini nanti ko boleh panggil data dari database untuk buat statistik (contoh: jumlah kereta, jumlah booking)
        
        $this->set('pageTitle', 'Sistem Car Rental - Dashboard');
    }
}