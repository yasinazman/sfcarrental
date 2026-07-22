<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        if ($this->request->getParam('controller') === 'Pages') {
            $this->Authentication->addUnauthenticatedActions(['display']);
        }
    }

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);

        // 1. BACA SESI SECARA GLOBAL (CARA TERBAIK CAKEPHP AUTHENTICATION)
        // Sistem akan tangkap data dari Authentication plugin secara automatik
        $identity = $this->request->getAttribute('identity');
        
        if ($identity) {
            // Jika user ada login, ambil datanya (Object/Entity)
            $userLogged = $identity->getOriginalData(); 
        } else {
            // Fallback: Jika gagal, baru kita cuba baca manual dari Session
            $session = $this->request->getSession();
            $userLogged = $session->read('Auth.Customer') ?? $session->read('Auth');
        }
        
        // 2. HANTAR DATA KE SEMUA VIEW & LAYOUT
        $this->set('userLogged', $userLogged);

        $controller = $this->request->getParam('controller');

        // Senarai controller yang MESTI menggunakan layout 'default' (awam)
        $publicControllers = ['Pages', 'Cars', 'Bookings', 'Categories', 'Terms', 'Fleets', 'Payments'];

        if (in_array($controller, $publicControllers)) {
            $this->viewBuilder()->setLayout('default');
        } 
        // Customers menggunakan layout mereka sendiri (biasanya ajax/login)
        elseif ($controller === 'Customers') {
            // Biarkan Customers controller tentukan layoutnya sendiri
        } 
        // Selain daripada di atas, kita anggap ia adalah modul Admin
        else {
            $this->viewBuilder()->setLayout('admin');
        }
    }
}