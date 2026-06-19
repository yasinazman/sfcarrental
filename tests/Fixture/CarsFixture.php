<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CarsFixture
 */
class CarsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'plate_number' => 'Lorem ipsum dolor ',
                'car_model' => 'Lorem ipsum dolor sit amet',
                'engine_capacity' => 'Lorem ipsum dolor sit amet',
                'daily_rate' => 1.5,
                'availability_status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-06-19 00:02:21',
                'modified' => '2026-06-19 00:02:21',
            ],
        ];
        parent::init();
    }
}
