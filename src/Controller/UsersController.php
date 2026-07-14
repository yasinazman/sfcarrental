<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        // Benarkan sesiapa akses login & register tanpa perlu login dulu
        $this->Authentication->addUnauthenticatedActions(['login', 'register']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        // Kalau dah login, terus redirect ke dashboard
        if ($result && $result->isValid()) {
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Users',
                'action' => 'dashboard',
            ]);
            return $this->redirect($redirect);
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Email atau kata laluan salah, sila cuba lagi.');
        }
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success('Pendaftaran berjaya! Sila log masuk.');
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error('Pendaftaran gagal, sila semak semula maklumat.');
        }
        $this->set(compact('user'));
    }

    public function dashboard()
    {
        $this->Authorization->skipAuthorization(); // atau letak logic authorization ikut kesesuaian
        $user = $this->Authentication->getIdentity();
        $this->set(compact('user'));
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
    }
}