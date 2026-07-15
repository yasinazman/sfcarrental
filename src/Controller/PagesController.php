<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\I18n\FrozenTime;

class PagesController extends AppController
{
    public function display(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }

        // --- ENJIN TAPISAN CARIAN KERETA ---
        if ($page === 'fleet') {
            $carsTable = $this->fetchTable('Cars');
            $query = $carsTable->find();

            // 1. Tangkap semua data dari borang carian (GET Request)
            $carType = strtolower($this->request->getQuery('car_type') ?? 'all');
            $pickupDateReq = $this->request->getQuery('pickup_date');
            $returnDateReq = $this->request->getQuery('return_date');
            
            // 2. Tapis ikut Kategori Kereta
            $validCategories = ['economy' => 'Economy', 'compact' => 'Compact', 'sedan' => 'Sedan', 'mpv' => 'MPV', 'suv' => 'SUV'];
            if ($carType !== 'all' && array_key_exists($carType, $validCategories)) {
                $query->where(['Cars.category' => $validCategories[$carType]]);
            }

            // 3. Tapis ikut Tarikh Bertembung (Bookings & Maintenances)
            if (!empty($pickupDateReq) && !empty($returnDateReq)) {
                $pickupDate = date('Y-m-d H:i:s', strtotime($pickupDateReq));
                $returnDate = date('Y-m-d H:i:s', strtotime($returnDateReq));

                // A. Cari ID Kereta yang dah DITEMPAH pada tarikh ini
                $bookedCarIds = $this->fetchTable('Bookings')->find()
                    ->select(['car_id'])
                    ->where([
                        'booking_status IN' => ['Pending Payment', 'Approved', 'Active'],
                        'start_date <' => $returnDate, // Tarikh ambil orang lain sebelum kita pulang
                        'end_date >' => $pickupDate    // Tarikh pulang orang lain selepas kita ambil
                    ])
                    ->extract('car_id')
                    ->toArray();

                // B. Cari ID Kereta yang masuk BENGKEL (Maintenance) pada tarikh ini
                $maintenanceCarIds = $this->fetchTable('Maintenances')->find()
                    ->select(['car_id'])
                    ->where([
                        'status IN' => ['Scheduled', 'In Progress'],
                        // Mengandaikan servis mengambil masa sekurang-kurangnya sehari (service_date)
                        'service_date >=' => date('Y-m-d 00:00:00', strtotime($pickupDateReq)),
                        'service_date <=' => date('Y-m-d 23:59:59', strtotime($returnDateReq))
                    ])
                    ->extract('car_id')
                    ->toArray();

                // C. Gabungkan ID kereta yang "Sibuk" dan buang dari senarai
                $unavailableCarIds = array_unique(array_merge($bookedCarIds, $maintenanceCarIds));

                if (!empty($unavailableCarIds)) {
                    $query->where(['Cars.id NOT IN' => $unavailableCarIds]);
                }
            }

            // Dapatkan senarai akhir kereta yang betul-betul AVAILABLE
            $cars = $query->order(['Cars.id' => 'DESC'])->all();
            
            $this->set(compact('cars', 'carType', 'pickupDateReq', 'returnDateReq'));
        }

        $this->set(compact('page', 'subpage'));

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }
}