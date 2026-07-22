<?php
declare(strict_types=1);

namespace App\Controller;

class TermsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Benarkan action 'index' (halaman utama Terms) diakses tanpa perlu login
        $this->Authentication->addUnauthenticatedActions(['index']);
    }

    public function index()
    {
        // Fungsi ini akan memaparkan halaman terms.php di bahagian frontend
    }
}