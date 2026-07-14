<?php
namespace App\Controller;

class AdminsCarsController extends AppController
{
    public function index()
    {
        $category = $this->request->getQuery('category');
        $search = $this->request->getQuery('search');
        
        $statusFilter = $this->request->getQuery('status'); 

        $carsTable = $this->fetchTable('Cars');
        $query = $carsTable->find()->order(['id' => 'DESC']);

        if (!empty($category)) {
            $query->where(['category' => $category]);
        }

        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'plate_number LIKE' => '%' . $search . '%',
                    'car_model LIKE' => '%' . $search . '%'
                ]
            ]);
        }

        if (!empty($statusFilter)) {
            $query->where(['availability_status' => $statusFilter]);
        }

        $cars = $query->all();

        $totalCars = $carsTable->find()->count();
        $availableCount = $carsTable->find()->where(['availability_status' => 'Available'])->count();
        $onRentCount = $carsTable->find()->where(['availability_status' => 'On Rent'])->count();
        $maintenanceCount = $carsTable->find()->where(['availability_status' => 'Maintenance'])->count();

        $this->set(compact('cars', 'category', 'search', 'statusFilter', 'totalCars', 'availableCount', 'onRentCount', 'maintenanceCount'));
        $this->set('pageTitle', 'Manage Cars');
    }

    public function export()
    {
        $category = $this->request->getQuery('category');
        $search = $this->request->getQuery('search');
        
        $carsTable = $this->fetchTable('Cars');
        $query = $carsTable->find()->order(['id' => 'DESC']);

        if (!empty($category)) {
            $query->where(['category' => $category]);
        }
        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'plate_number LIKE' => '%' . $search . '%',
                    'car_model LIKE' => '%' . $search . '%'
                ]
            ]);
        }
        
        $cars = $query->all();
        $csvData = "Plate Number,Car Model,Category,Engine (cc),Transmission,Seat Capacity,Daily Rate (RM),Status\n";
        
        foreach ($cars as $car) {
            $plate = '"' . $car->plate_number . '"';
            $model = '"' . $car->car_model . '"';
            $cat = '"' . ($car->category ?: 'N/A') . '"';
            $engine = '"' . ($car->engine_capacity ?: 'N/A') . '"';
            $trans = '"' . ($car->transmission ?: 'N/A') . '"';
            $seats = '"' . ($car->seat_capacity ?: 'N/A') . '"';
            $rate = $car->daily_rate;
            $status = $car->availability_status;
            
            $csvData .= "{$plate},{$model},{$cat},{$engine},{$trans},{$seats},{$rate},{$status}\n";
        }

        $fileName = 'Cars_Report_' . date('Ymd_His') . '.csv';
        return $this->response->withStringBody($csvData)
            ->withType('csv')
            ->withDownload($fileName);
    }

    // FUNGSI BAHARU: Tindakan Tukar Status Pantas
    public function toggleStatus($id = null, $status = null)
    {
        $this->request->allowMethod(['post']);
        $carsTable = $this->fetchTable('Cars');
        $car = $carsTable->get($id);
        
        $validStatuses = ['Available', 'On Rent', 'Maintenance'];
        if (in_array($status, $validStatuses)) {
            $car->availability_status = $status;
            if ($carsTable->save($car)) {
                $this->Flash->success("{$car->plate_number} status has been updated to {$status}.");
            } else {
                $this->Flash->error("Unable to update status.");
            }
        }
        return $this->redirect($this->referer(['action' => 'index']));
    }

    public function view($id = null)
    {
        $carsTable = $this->fetchTable('Cars');
        $car = $carsTable->get($id);
        $this->set(compact('car'));
        $this->set('pageTitle', 'View Car Details');
    }

    public function add()
    {
        $carsTable = $this->fetchTable('Cars');
        $car = $carsTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $image = $this->request->getData('image_file');
            
            if ($image !== null && !$image->getError()) {
                $fileName = time() . '_' . $image->getClientFilename();
                $dir = WWW_ROOT . 'img' . DS . 'cars';
                if (!is_dir($dir)) { mkdir($dir, 0777, true); }
                $targetPath = $dir . DS . $fileName;
                $image->moveTo($targetPath);
                $data['image'] = $fileName;
            }

            $car = $carsTable->patchEntity($car, $data);
            if (empty($car->availability_status)) {
                $car->availability_status = 'Available';
            }

            if (empty($car->latitude) || empty($car->longitude)) {
                $car->latitude = '3.068600';
                $car->longitude = '101.490400';
            }

            if ($carsTable->save($car)) {
                $this->Flash->success('New car and specifications have been successfully saved.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Unable to add the car. Please check the form and try again.');
        }

        $this->set(compact('car'));
        $this->set('pageTitle', 'Add New Car');
    }

    public function edit($id = null)
    {
        $carsTable = $this->fetchTable('Cars');
        $car = $carsTable->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $image = $this->request->getData('image_file');

            if ($image !== null && !$image->getError()) {
                $fileName = time() . '_' . $image->getClientFilename();
                $dir = WWW_ROOT . 'img' . DS . 'cars';
                if (!empty($car->image) && file_exists($dir . DS . $car->image)) {
                    unlink($dir . DS . $car->image);
                }
                $targetPath = $dir . DS . $fileName;
                $image->moveTo($targetPath);
                $data['image'] = $fileName;
            }

            $car = $carsTable->patchEntity($car, $data);

            if ($carsTable->save($car)) {
                $this->Flash->success('Car details have been successfully updated.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Unable to update the car. Please try again.');
        }

        $this->set(compact('car'));
        $this->set('pageTitle', 'Edit Car Details');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $carsTable = $this->fetchTable('Cars');
        $car = $carsTable->get($id);

        if (!empty($car->image)) {
            $imagePath = WWW_ROOT . 'img' . DS . 'cars' . DS . $car->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($carsTable->delete($car)) {
            $this->Flash->success('The car has been permanently deleted from the fleet.');
        } else {
            $this->Flash->error('Unable to delete the car. Please try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}