<?php
namespace App\Controller;

class AdminsCarsController extends AppController
{
    public function index()
    {
        $category = $this->request->getQuery('category');
        
        $carsTable = $this->fetchTable('Cars');
        $query = $carsTable->find()->order(['id' => 'DESC']);
        
        if (!empty($category)) {
            $query->where(['category' => $category]);
        }
        
        $cars = $query->all();

        $this->set(compact('cars', 'category'));
        $this->set('pageTitle', 'Manage Cars');
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
            
            // Logik Muat Naik Gambar (Upload Image)
            $image = $this->request->getData('image_file');
            
            if ($image !== null && !$image->getError()) {
                // Hasilkan nama fail unik supaya tak bertindih
                $fileName = time() . '_' . $image->getClientFilename();
                
                // Cipta folder 'cars' dalam webroot/img kalau belum wujud
                $dir = WWW_ROOT . 'img' . DS . 'cars';
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                
                // Pindahkan gambar dari fail sementara ke folder projek
                $targetPath = $dir . DS . $fileName;
                $image->moveTo($targetPath);
                
                // Simpan nama fail dalam data untuk dimasukkan ke database
                $data['image'] = $fileName;
            }

            $car = $carsTable->patchEntity($car, $data);
            
            if (empty($car->availability_status)) {
                $car->availability_status = 'Available';
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

            // Handle new image upload if provided
            if ($image !== null && !$image->getError()) {
                $fileName = time() . '_' . $image->getClientFilename();
                $dir = WWW_ROOT . 'img' . DS . 'cars';
                
                // Delete the old image file to save server space
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
        // Only allow POST or DELETE requests for security
        $this->request->allowMethod(['post', 'delete']);
        
        $carsTable = $this->fetchTable('Cars');
        $car = $carsTable->get($id);

        // Delete the associated image file from the folder
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