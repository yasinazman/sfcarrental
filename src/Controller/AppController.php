<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');

        $this->loadComponent('Authentication.Authentication');
    }

    public function beforeRender(\Cake\Event\EventInterface $event)
    {
        if ($this->request->getParam('controller') === 'Pages') {
            $this->viewBuilder()->setLayout('default');
        } 
        else {
            $this->viewBuilder()->setLayout('admin');
        }
    }
}