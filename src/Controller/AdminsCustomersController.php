<?php
namespace App\Controller;

class AdminsCustomersController extends AppController
{
    public function index()
    {
        $customersTable = $this->fetchTable('Customers');
        // Susun pelanggan dari yang paling baru berdaftar
        $customers = $customersTable->find()->order(['id' => 'DESC'])->all();

        $this->set(compact('customers'));
        $this->set('pageTitle', 'Manage Customers');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $customersTable = $this->fetchTable('Customers');
        $customer = $customersTable->get($id);

        $dir = WWW_ROOT . 'img' . DS . 'customers';

        // Buang fail IC jika wujud
        if (!empty($customer->ic_file_path) && file_exists($dir . DS . $customer->ic_file_path)) {
            unlink($dir . DS . $customer->ic_file_path);
        }

        // Buang fail Lesen jika wujud
        if (!empty($customer->license_file_path) && file_exists($dir . DS . $customer->license_file_path)) {
            unlink($dir . DS . $customer->license_file_path);
        }

        if ($customersTable->delete($customer)) {
            $this->Flash->success('Customer record and associated documents have been deleted.');
        } else {
            $this->Flash->error('Unable to delete the customer. Please try again.');
        }

        return $this->redirect(['action' => 'index']);
    }
}