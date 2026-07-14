<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        
        if ($this->components()->has('Authentication')) {
            $this->Authentication->addUnauthenticatedActions(['login', 'register', 'dashboard']);
        }
    }

    public function login()
    {
        // Matikan layout global kawan kau secara total untuk page ini
        $this->viewBuilder()->disableAutoLayout();
    }

    public function register()
    {
        // Matikan layout global kawan kau secara total untuk page ini
        $this->viewBuilder()->disableAutoLayout();
    }

    public function dashboard()
    {
        if ($this->components()->has('Authorization')) {
            $this->Authorization->skipAuthorization();
        }
        // Matikan layout global kawan kau secara total untuk page ini
        $this->viewBuilder()->disableAutoLayout();
    }

    public function profile()
{
    $identity = $this->request->getAttribute('authentication')->getIdentity();
    $customerId = $identity->id;

    // Load model Customers secara manual jika berada di UsersController
    $this->loadModel('Customers');
    
    // Ambil data profil customer
    $customer = $this->Customers->get($customerId);

    $this->set(compact('customer'));
}
}