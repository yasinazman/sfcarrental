<?php
declare(strict_types=1);

namespace App\Controller;

class CategoriesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Benarkan action 'index' dan 'view' diakses tanpa perlu login
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    public function index()
    {
        // Logik anda
    }
}