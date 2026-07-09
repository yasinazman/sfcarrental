<?php
namespace App\Controller;

class AdminsCustomersController extends AppController
{
    public function index()
    {
        $search = $this->request->getQuery('search');
        $statusFilter = $this->request->getQuery('status');
        
        $customersTable = $this->fetchTable('Customers');
        $bookingsTable = $this->fetchTable('Bookings');

        $query = $customersTable->find()->order(['Customers.id' => 'DESC']);

        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'Customers.full_name LIKE' => '%' . $search . '%',
                    'Customers.phone_number LIKE' => '%' . $search . '%'
                ]
            ]);
        }

        if (!empty($statusFilter)) {
            if ($statusFilter === 'Blacklisted') {
                $query->where(['Customers.account_status' => 'Blacklisted']);
            } elseif ($statusFilter === 'Pending Verification') {
                $query->where([
                    'OR' => [
                        ['Customers.ic_file_path IS' => null], 
                        ['Customers.ic_file_path' => ''], 
                        ['Customers.license_file_path IS' => null], 
                        ['Customers.license_file_path' => '']
                    ]
                ]);
            }
        }

        $customers = $query->all();

        $totalCustomers = $customersTable->find()->count();
        $blacklistedCount = $customersTable->find()->where(['account_status' => 'Blacklisted'])->count();
        $pendingCount = $customersTable->find()->where([
            'OR' => [
                ['ic_file_path IS' => null], ['ic_file_path' => ''], 
                ['license_file_path IS' => null], ['license_file_path' => '']
            ]
        ])->count();

        $customerBookings = [];
        $allBookings = $bookingsTable->find('all');
        foreach ($allBookings as $b) {
            if (!isset($customerBookings[$b->customer_id])) {
                $customerBookings[$b->customer_id] = 0;
            }
            $customerBookings[$b->customer_id]++;
        }

        $this->set(compact('customers', 'search', 'statusFilter', 'totalCustomers', 'blacklistedCount', 'pendingCount', 'customerBookings'));
        $this->set('pageTitle', 'Customer Database');
    }

    public function add()
    {
        $customersTable = $this->fetchTable('Customers');
        $customer = $customersTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            $uploadPath = WWW_ROOT . 'img' . DS . 'customers' . DS;
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $filesToUpload = [
                'ic_file' => 'ic_file_path',
                'ic_back_file' => 'ic_back_file_path',
                'license_file' => 'license_file_path'
            ];

            foreach ($filesToUpload as $formField => $dbField) {
                $file = $this->request->getData($formField);
                if ($file !== null && !$file->getError()) {
                    $fileName = time() . '_' . $file->getClientFilename();
                    $file->moveTo($uploadPath . $fileName);
                    $data[$dbField] = $fileName;
                }
            }

            if (empty($data['account_status'])) {
                $data['account_status'] = 'Active';
            }

            $customer = $customersTable->patchEntity($customer, $data);
            
            if ($customersTable->save($customer)) {
                $this->Flash->success('New walk-in customer has been successfully registered.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Unable to register the customer. Please check the form and try again.');
        }

        $this->set(compact('customer'));
        $this->set('pageTitle', 'Register Walk-In Customer');
    }

    public function toggleStatus($id = null)
    {
        $this->request->allowMethod(['post']);
        $customersTable = $this->fetchTable('Customers');
        $customer = $customersTable->get($id);
        
        $customer->account_status = ($customer->account_status === 'Blacklisted') ? 'Active' : 'Blacklisted';
        
        if ($customersTable->save($customer)) {
            $statusText = $customer->account_status === 'Blacklisted' ? 'blacklisted' : 'activated';
            $this->Flash->success("{$customer->full_name}'s account has been {$statusText}.");
        } else {
            $this->Flash->error("Unable to update account status.");
        }
        
        return $this->redirect($this->referer(['action' => 'index']));
    }

    public function view($id = null)
    {
        $customersTable = $this->fetchTable('Customers');
        $customer = $customersTable->get($id);

        $bookingsTable = $this->fetchTable('Bookings');
        $bookings = $bookingsTable->find()
            ->where(['customer_id' => $id])
            ->contain(['Cars'])
            ->order(['Bookings.id' => 'DESC'])
            ->all();

        $totalSpent = 0;
        $completedTrips = 0;
        foreach ($bookings as $b) {
            if (strtolower($b->booking_status) === 'completed') {
                $totalSpent += (float)$b->total_price;
                $completedTrips++;
            }
        }

        $this->set(compact('customer', 'bookings', 'totalSpent', 'completedTrips'));
        $this->set('pageTitle', 'Customer Profile');
    }
}