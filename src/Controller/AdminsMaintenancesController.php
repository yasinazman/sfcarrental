<?php
namespace App\Controller;

class AdminsMaintenancesController extends AppController
{
    public function index()
    {
        $maintenancesTable = $this->fetchTable('Maintenances');
        
        $maintenances = $maintenancesTable->find()
            ->contain(['Cars'])
            ->order(['Maintenances.service_date' => 'DESC'])
            ->all();

        $this->set(compact('maintenances'));
        $this->set('pageTitle', 'Fleet Maintenance');
    }

    public function view($id = null)
    {
        $maintenancesTable = $this->fetchTable('Maintenances');
        
        // Tarik rekod spesifik berdasarkan ID dan pautkan dengan data kereta
        $maintenance = $maintenancesTable->get($id, [
            'contain' => ['Cars']
        ]);

        $this->set(compact('maintenance'));
        $this->set('pageTitle', 'View Maintenance Details');
    }

    public function add()
    {
        $maintenancesTable = $this->fetchTable('Maintenances');
        $maintenance = $maintenancesTable->newEmptyEntity();

        if ($this->request->is('post')) {
            $maintenance = $maintenancesTable->patchEntity($maintenance, $this->request->getData());
            if ($maintenancesTable->save($maintenance)) {
                $this->Flash->success('Maintenance record has been successfully added.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Unable to add the record. Please check the form and try again.');
        }

        // Tarik senarai kereta (gabungkan model dan plate) untuk Dropdown
        $carsTable = $this->fetchTable('Cars');
        $cars = $carsTable->find('list', [
            'keyField' => 'id',
            'valueField' => function ($car) {
                return $car->car_model . ' (' . $car->plate_number . ')';
            }
        ])->toArray();

        $this->set(compact('maintenance', 'cars'));
        $this->set('pageTitle', 'Add Maintenance Record');
    }

    public function edit($id = null)
    {
        $maintenancesTable = $this->fetchTable('Maintenances');
        $maintenance = $maintenancesTable->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $maintenance = $maintenancesTable->patchEntity($maintenance, $this->request->getData());
            if ($maintenancesTable->save($maintenance)) {
                $this->Flash->success('Maintenance record has been updated.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Unable to update the record. Please check the form.');
        }

        // Tarik senarai kereta untuk dropdown
        $carsTable = $this->fetchTable('Cars');
        $cars = $carsTable->find('list', [
            'keyField' => 'id',
            'valueField' => function ($car) {
                return $car->car_model . ' (' . $car->plate_number . ')';
            }
        ])->toArray();

        $this->set(compact('maintenance', 'cars'));
        $this->set('pageTitle', 'Edit Maintenance Record');
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $maintenancesTable = $this->fetchTable('Maintenances');
        $maintenance = $maintenancesTable->get($id);
        
        if ($maintenancesTable->delete($maintenance)) {
            $this->Flash->success('The maintenance record has been deleted.');
        } else {
            $this->Flash->error('Unable to delete the record.');
        }

        return $this->redirect(['action' => 'index']);
    }
}