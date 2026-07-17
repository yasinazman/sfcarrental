<?php
declare(strict_types=1);

namespace App\Controller;

use Authentication\PasswordHasher\DefaultPasswordHasher; // Untuk semak password nanti

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 */
class CustomersController extends AppController
{
    /**
     * Initialize method
     */
    public function initialize(): void
    {
        parent::initialize();
        // Tiada lagi loadModel() di sini bagi mengelakkan ralat "Call to undefined method"
    }

    /**
     * BEFORE FILTER METHOD
     * Membenarkan akses ke login dan add tanpa di-redirect oleh Authentication Middleware
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Membuka akses untuk login & register kepada pelawat yang belum mendaftar masuk
        if ($this->components()->has('Authentication')) {
            $this->Authentication->allowUnauthenticated(['login', 'add']);
        }

        // Sebagai sokongan tambahan jika anda menggunakan komponen Auth legacy
        if (isset($this->Auth)) {
            $this->Auth->allow(['login', 'add']);
        }
    }

    /**
     * USER DASHBOARD METHOD
     */
    public function dashboard()
    {
        // 1. Ambil data session customer
        $session = $this->request->getSession();
        $customerSession = $session->read('Auth.Customer');

        if (!$customerSession) {
            $this->Flash->error(__('Sila log masuk terlebih dahulu untuk mengakses dashboard.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        // 2. Tarik data profil customer terkini
        $customer = $this->Customers->get($customerSession['id']);

        // 3. Panggil table Bookings & Cars (Penting untuk dropdown kereta)
        $bookingsTable = $this->fetchTable('Bookings');
        $carsTable = $this->fetchTable('Cars');

        // 4. Ambil senarai kereta untuk dropdown
        $cars = $carsTable->find('list', [
            'keyField' => 'id',
            'valueField' => 'brand' // Anda boleh tukar kepada 'model_name' jika perlu
        ])->toArray();

        // 5. Cari semua booking milik customer tersebut
        $bookings = $bookingsTable->find('all')
            ->where(['customer_id' => $customer->id])
            ->contain(['Cars'])
            ->order(['Bookings.created' => 'DESC'])
            ->all();

        // 6. Hantar 'cars' ke template view supaya borang tempahan boleh berfungsi
        $this->set(compact('customer', 'bookings', 'cars'));
    }
    
    /**
     * Index method
     */
    public function index()
    {
        $query = $this->Customers->find();
        $customers = $this->paginate($query);

        $this->set(compact('customers'));
    }

    /**
     * View method
     */
    public function view($id = null)
    {
        $customer = $this->Customers->get($id, contain: ['Bookings']);
        $this->set(compact('customer'));
    }

    /**
     * ADD METHOD (Register guna Phone Number)
     */
    public function add()
    {
        // MATIKAN LAYOUT ADMIN: Supaya borang pendaftaran tidak berterabur dengan sidebar admin
        $this->viewBuilder()->setLayout('ajax');

        $customer = $this->Customers->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // Semak jika nombor telefon sudah wujud
            $existing = $this->Customers->findByPhoneNumber($data['phone_number'])->first();
            if ($existing) {
                $this->Flash->error(__('Nombor telefon ini telah pun didaftarkan. Sila guna nombor lain.'));
                return $this->redirect($this->referer());
            }

            // --- PROSES UPLOAD FAIL ---
            $uploadFolder = WWW_ROOT . 'uploads' . DS;
            if (!is_dir($uploadFolder)) {
                mkdir($uploadFolder, 0775, true);
            }

            // 1. Fail IC Depan
            $icFile = $this->request->getData('ic_file');
            if ($icFile && $icFile->getError() === UPLOAD_ERR_OK) {
                $icName = time() . '_ic_front_' . $icFile->getClientFilename();
                $icFile->moveTo($uploadFolder . $icName);
                $data['ic_file_path'] = 'uploads/' . $icName;
            }

            // 2. Fail IC Belakang
            $icBackFile = $this->request->getData('ic_back_file');
            if ($icBackFile && $icBackFile->getError() === UPLOAD_ERR_OK) {
                $icBackName = time() . '_ic_back_' . $icBackFile->getClientFilename();
                $icBackFile->moveTo($uploadFolder . $icBackName);
                $data['ic_back_file_path'] = 'uploads/' . $icBackName;
            }

            // 3. Fail Lesen
            $licenseFile = $this->request->getData('license_file');
            if ($licenseFile && $licenseFile->getError() === UPLOAD_ERR_OK) {
                $licenseName = time() . '_license_' . $licenseFile->getClientFilename();
                $licenseFile->moveTo($uploadFolder . $licenseName);
                $data['license_file_path'] = 'uploads/' . $licenseName;
            }

            // Set account status secara default
            $data['account_status'] = 'Active';

            $customer = $this->Customers->patchEntity($customer, $data);
            
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('Pendaftaran akaun berjaya! Sila log masuk.'));
                return $this->redirect($this->referer());
            }
            
            $this->Flash->error(__('Pendaftaran gagal. Sila semak semula maklumat anda.'));
        }
        $this->set(compact('customer'));
    }

    /**
     * LOGIN METHOD (Login guna Phone Number & Password)
     */
    public function login()
    {
        // MATIKAN LAYOUT ADMIN: Menghalang layout/sidebar admin daripada bercampur dengan halaman login customer
        $this->viewBuilder()->setLayout('ajax');

        // Benarkan request GET dan POST supaya paparan tidak menyekat proses
        $this->request->allowMethod(['get', 'post']);
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            
            // 1. Cari customer berdasarkan phone_number
            $customer = $this->Customers->findByPhoneNumber($data['phone_number'])->first();
            
            if ($customer) {
                // 2. Semak password menggunakan hasher CakePHP
                $hasher = new DefaultPasswordHasher();
                if ($hasher->check($data['password'], $customer->password)) {
                    
                    // 3. Simpan data ke session
                    $session = $this->request->getSession();
                    $session->write('Auth.Customer', $customer);
                    
                    $this->Flash->success(__('Selamat datang kembali, ' . $customer->full_name));
                    
                    // Lepas login berjaya, hantar terus ke Dashboard!
                    return $this->redirect(['controller' => 'Customers', 'action' => 'dashboard']);
                }
            }
            
            $this->Flash->error(__('Nombor telefon atau kata laluan anda salah.'));
            return $this->redirect($this->referer());
        }
        
        // Jika diakses secara GET, paparkan template view login (biasanya templates/Customers/login.php)
    }

    /**
     * LOGOUT METHOD
     */
    public function logout()
    {
        $this->request->getSession()->destroy();
        $this->Flash->success(__('Anda telah berjaya log keluar.'));
        return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
    }
    
    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $customer = $this->Customers->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $this->set(compact('customer'));
    }

    /**
     * Delete method
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customer = $this->Customers->get($id);
        if ($this->Customers->delete($customer)) {
            $this->Flash->success(__('The customer has been deleted.'));
        } else {
            $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}