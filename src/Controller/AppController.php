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
        if ($this->request->getParam('controller') === 'Pages') {
            $this->viewBuilder()->setLayout('default');
        } 
        else {
            $this->viewBuilder()->setLayout('admin');
        }
    }
}