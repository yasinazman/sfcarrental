<?php
declare(strict_types=1);

namespace App\Controller;

class CategoriesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Paksa guna layout default (pelanggan) untuk semua action dalam controller ini
        $this->viewBuilder()->setLayout('default');
    }

    public function index()
    {
        // Logik anda
    }
}