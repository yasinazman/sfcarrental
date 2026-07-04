<?php
namespace App\Controller;

class AdminsBookingsController extends AppController
{
    public function index()
    {
        $bookingsTable = $this->fetchTable('Bookings');
        
        // Tarik data tempahan BERSERTA data pelanggan dan kereta
        $bookings = $bookingsTable->find()
            ->contain(['Customers', 'Cars'])
            ->order(['Bookings.id' => 'DESC'])
            ->all();

        $this->set(compact('bookings'));
        $this->set('pageTitle', 'Manage Bookings');
    }

    public function edit($id = null)
    {
        $bookingsTable = $this->fetchTable('Bookings');
        $booking = $bookingsTable->get($id, [
            'contain' => ['Customers', 'Cars']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $booking = $bookingsTable->patchEntity($booking, $this->request->getData());
            
            if ($bookingsTable->save($booking)) {
                $this->Flash->success('Booking status and details have been successfully updated.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Unable to update the booking. Please check the form and try again.');
        }

        $this->set(compact('booking'));
        $this->set('pageTitle', 'Update Booking Status');
    }
}