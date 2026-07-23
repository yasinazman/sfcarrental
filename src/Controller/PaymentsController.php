<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 */
class PaymentsController extends AppController
{
    // Memastikan layout yang digunakan adalah 'default' (untuk pelanggan)
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('default');
    }

    // Fungsi asal dikekalkan untuk kegunaan Admin
    public function index()
    {
        $query = $this->Payments->find()->contain(['Bookings']);
        $payments = $this->paginate($query);
        $this->set(compact('payments'));
    }

    public function view($id = null)
    {
        // Memastikan hubungan 'Bookings' dan 'Cars' ditarik dengan lengkap dari pangkalan data
        $payment = $this->Payments->get($id, [
            'contain' => [
                'Bookings' => [
                    'Cars'
                ]
            ]
        ]);

        $this->set(compact('payment'));
    }

    /**
     * FUNGSI: Process Payment (Untuk pelanggan)
     */
    public function process($bookingId = null)
    {
        // 1. Dapatkan maklumat booking
        $booking = $this->fetchTable('Bookings')->get($bookingId);
        $payment = $this->Payments->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            $payment->booking_id = $bookingId;
            $payment->payment_time = date('Y-m-d H:i:s');
            $payment->payment_status = 'Pending Verification';

            // 2. Proses upload resit
            $file = $this->request->getData('receipt_file');
            if ($file && $file->getError() === UPLOAD_ERR_OK) {
                $fileName = time() . '_' . $file->getClientFilename();
                $file->moveTo(WWW_ROOT . 'uploads' . DS . $fileName);
                $payment->receipt_path = 'uploads/' . $fileName;
            }

            if ($this->Payments->save($payment)) {
                // 3. Update status tempahan
                $booking->booking_status = 'Payment Submitted';
                $this->fetchTable('Bookings')->save($booking);
                
                $this->Flash->success(__('Pembayaran telah dihantar. Terima kasih!'));
                return $this->redirect(['controller' => 'Customers', 'action' => 'dashboard']);
            }
            $this->Flash->error(__('Gagal menghantar pembayaran. Sila cuba lagi.'));
        }
        
        $this->set(compact('booking', 'payment'));
    }

    // Fungsi Add (Admin)
    public function add()
    {
        $payment = $this->Payments->newEmptyEntity();
        if ($this->request->is('post')) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment could not be saved. Please, try again.'));
        }
        $bookings = $this->Payments->Bookings->find('list', limit: 200)->all();
        $this->set(compact('payment', 'bookings'));
    }

    public function edit($id = null)
    {
        $payment = $this->Payments->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            if ($this->Payments->save($payment)) {
                $this->Flash->success(__('The payment has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment could not be saved. Please, try again.'));
        }
        $bookings = $this->Payments->Bookings->find('list', limit: 200)->all();
        $this->set(compact('payment', 'bookings'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $payment = $this->Payments->get($id);
        if ($this->Payments->delete($payment)) {
            $this->Flash->success(__('The payment has been deleted.'));
        } else {
            $this->Flash->error(__('The payment could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}