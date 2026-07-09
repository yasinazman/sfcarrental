<?php
namespace App\Controller;

use Cake\Routing\Router;

class AdminsBookingsController extends AppController
{
    public function index()
    {
        $category = $this->request->getQuery('category');
        $search = $this->request->getQuery('search');
        
        $bookingsTable = $this->fetchTable('Bookings');
        $maintenancesTable = $this->fetchTable('Maintenances');

        $query = $bookingsTable->find()
            ->contain(['Customers', 'Cars'])
            ->order(['Bookings.id' => 'DESC']);

        if (!empty($category)) {
            $query->where(['Cars.category' => $category]);
        }
        
        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'Bookings.id' => (int)str_replace('#', '', $search),
                    'Customers.full_name LIKE' => '%' . $search . '%'
                ]
            ]);
        }
        
        $bookings = $query->all();

        $pendingCount = 0;
        $activeCount = 0;
        $completedCount = 0;
        $totalRevenue = 0;

        $calendarEvents = [];
        foreach ($bookings as $booking) {
            $status = strtolower($booking->booking_status);
            $color = '#17a2b8';
            
            if (strpos($status, 'pending') !== false) {
                $color = '#ffc107';
                $pendingCount++;
            } elseif (strpos($status, 'approved') !== false || strpos($status, 'active') !== false) {
                $color = '#28a745';
                $activeCount++;
                $totalRevenue += (float)$booking->total_price;
            } elseif (strpos($status, 'completed') !== false) {
                $color = '#17a2b8';
                $completedCount++;
                $totalRevenue += (float)$booking->total_price;
            } elseif (strpos($status, 'cancelled') !== false) {
                $color = '#dc3545';
            }

            $calendarEvents[] = [
                'id' => 'B' . $booking->id,
                'title' => $booking->car->plate_number . ' - ' . ($booking->customer->full_name ?? 'N/A'),
                'start' => $booking->start_date->format('Y-m-d\TH:i:s'),
                'end' => $booking->end_date->format('Y-m-d\TH:i:s'),
                'color' => $color,
                'url' => Router::url(['action' => 'view', $booking->id])
            ];
        }

        $mQuery = $maintenancesTable->find()->contain(['Cars']);
        if (!empty($category)) {
            $mQuery->where(['Cars.category' => $category]);
        }
        $maintenances = $mQuery->all();

        foreach ($maintenances as $m) {
            $calendarEvents[] = [
                'id' => 'M' . $m->id,
                'title' => '🔧 MAINTENANCE: ' . $m->car->plate_number,
                'start' => $m->service_date->format('Y-m-d'),
                'allDay' => true,
                'color' => '#343a40',
                'url' => Router::url(['controller' => 'AdminsMaintenances', 'action' => 'view', $m->id])
            ];
        }

        $this->set(compact('bookings', 'category', 'search', 'calendarEvents', 'pendingCount', 'activeCount', 'completedCount', 'totalRevenue'));
        $this->set('pageTitle', 'Manage Bookings');
    }

    public function quickStatus($id = null, $status = null)
    {
        $this->request->allowMethod(['post']);
        $bookingsTable = $this->fetchTable('Bookings');
        $booking = $bookingsTable->get($id);
        
        $validStatuses = ['Approved', 'Cancelled', 'Completed'];
        if (in_array($status, $validStatuses)) {
            $booking->booking_status = $status;
            if ($bookingsTable->save($booking)) {
                $this->Flash->success("Booking #{$id} has been successfully {$status}.");
            } else {
                $this->Flash->error("Unable to update Booking #{$id}.");
            }
        }
        
        return $this->redirect($this->referer(['action' => 'index']));
    }

    public function view($id = null)
    {
        $bookingsTable = $this->fetchTable('Bookings');
        $booking = $bookingsTable->get($id, [
            'contain' => ['Customers', 'Cars']
        ]);

        $this->set(compact('booking'));
        $this->set('pageTitle', 'Booking Details');
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

    public function export()
    {
        $category = $this->request->getQuery('category');
        $search = $this->request->getQuery('search');
        
        $bookingsTable = $this->fetchTable('Bookings');
        $query = $bookingsTable->find()
            ->contain(['Customers', 'Cars'])
            ->order(['Bookings.id' => 'DESC']);

        if (!empty($category)) {
            $query->where(['Cars.category' => $category]);
        }
        
        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'Bookings.id' => (int)str_replace('#', '', $search),
                    'Customers.full_name LIKE' => '%' . $search . '%'
                ]
            ]);
        }
        
        $bookings = $query->all();

        $csvData = "Booking ID,Customer Name,Car Model,Plate Number,Start Date,End Date,Total Price (RM),Status\n";
        
        foreach ($bookings as $booking) {
            $id = 'B' . $booking->id;
            $name = '"' . ($booking->customer->full_name ?? 'N/A') . '"';
            $model = '"' . ($booking->car->car_model ?? 'N/A') . '"';
            $plate = '"' . ($booking->car->plate_number ?? 'N/A') . '"';
            $start = $booking->start_date->format('Y-m-d H:i');
            $end = $booking->end_date->format('Y-m-d H:i');
            $price = $booking->total_price;
            $status = $booking->booking_status;
            
            $csvData .= "{$id},{$name},{$model},{$plate},{$start},{$end},{$price},{$status}\n";
        }

        $fileName = 'Bookings_Report_' . date('Ymd_His') . '.csv';
        return $this->response->withStringBody($csvData)
            ->withType('csv')
            ->withDownload($fileName);
    }
}