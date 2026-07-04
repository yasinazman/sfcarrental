<?php
declare(strict_types=1);

namespace App\Controller;

class AdminsController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login', 'add']);
    }

    public function index()
    {
        $admins = $this->Admins->find()->all();
        
        $this->set(compact('admins'));
        $this->set('pageTitle', 'Manage Administrators');
    }

    public function view($id = null)
    {
        $admin = $this->Admins->get($id, contain: []);
        $this->set(compact('admin'));
    }

    public function add()
    {
        $admin = $this->Admins->newEmptyEntity();
        if ($this->request->is('post')) {
            $admin = $this->Admins->patchEntity($admin, $this->request->getData());
            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        $this->set(compact('admin'));
        
        $this->set('pageTitle', 'Add New Administrator');
    }

    public function edit($id = null)
    {
        $admin = $this->Admins->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $admin = $this->Admins->patchEntity($admin, $this->request->getData());
            if ($this->Admins->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        $this->set(compact('admin'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $admin = $this->Admins->get($id);
        
        // Elak terbuang akaun Master (ID 1)
        if ($id == 1) {
            $this->Flash->error(__('You cannot delete the master administrator account.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Admins->delete($admin)) {
            $this->Flash->success(__('The admin has been deleted.'));
        } else {
            $this->Flash->error(__('The admin could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        $this->viewBuilder()->disableAutoLayout();
        $this->request->allowMethod(['get', 'post']);
        
        $result = $this->Authentication->getResult();

        if ($result && $result->isValid()) {
            return $this->redirect(['controller' => 'AdminsDashboard', 'action' => 'index']);
        }
        
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Invalid username or password. Please try again.');
        }
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Admins', 'action' => 'login']);
        }
    }
}