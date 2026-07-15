<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;

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

        if ($page === 'fleet') {
            $carsTable = $this->fetchTable('Cars');
            $query = $carsTable->find();

            $carType = strtolower($this->request->getQuery('car_type') ?? 'all');
            
            $validCategories = ['economy' => 'Economy', 'compact' => 'Compact', 'sedan' => 'Sedan', 'mpv' => 'MPV', 'suv' => 'SUV'];

            if ($carType !== 'all' && array_key_exists($carType, $validCategories)) {
                $query->where(['category' => $validCategories[$carType]]);
            }

            $cars = $query->order(['id' => 'DESC'])->all();
            
            $this->set(compact('cars', 'carType'));
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