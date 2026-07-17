<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Cars Controller
 *
 * @property \App\Model\Table\CarsTable $Cars
 */
class CarsController extends AppController
{
    public function index()
    {
        $query = $this->Cars->find();
        $cars = $this->paginate($query);
        $this->set(compact('cars'));
    }

    public function view($id = null)
    {
        $car = $this->Cars->get($id, contain: ['Bookings']);
        $this->set(compact('car'));
    }

    public function add()
    {
        $car = $this->Cars->newEmptyEntity();
        if ($this->request->is('post')) {
            $car = $this->Cars->patchEntity($car, $this->request->getData());
            if ($this->Cars->save($car)) {
                $this->Flash->success(__('The car has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The car could not be saved. Please, try again.'));
        }
        $this->set(compact('car'));
    }

    public function edit($id = null)
    {
        $car = $this->Cars->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $car = $this->Cars->patchEntity($car, $this->request->getData());
            if ($this->Cars->save($car)) {
                $this->Flash->success(__('The car has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The car could not be saved. Please, try again.'));
        }
        $this->set(compact('car'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $car = $this->Cars->get($id);
        if ($this->Cars->delete($car)) {
            $this->Flash->success(__('The car has been deleted.'));
        } else {
            $this->Flash->error(__('The car could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function browse()
    {
        $cars = $this->Cars->find('all')->toArray();
        $this->set(compact('cars'));
    }

   public function search() 
{
    // Pastikan data ini diisi semasa form carian disubmit
    $searchData = $this->request->getQueryParams(); 
    
    // SIMPAN KE DALAM SESSION (Ini mesti ada!)
    $this->request->getSession()->write('Booking.search_data', $searchData);
        
        // ... logik filter kereta anda ...
    // Letak kod di dalam bracket { ini
    $this->viewBuilder()->setLayout('default');

    $pickupLocation = $this->request->getQuery('pickup_location', '');
    $carType = $this->request->getQuery('car_category', '');
    $pickupDate = $this->request->getQuery('pickup_date', '');
    $returnDate = $this->request->getQuery('return_date', '');
    
    $query = $this->Cars->find('all');
    
    if (!empty($carType) && $carType !== 'all') {
        $query->where(['car_category' => $carType]);
    }
    
    $cars = $query->all();
    
    $this->set(compact('cars', 'pickupLocation', 'pickupDate', 'returnDate'));
}
}