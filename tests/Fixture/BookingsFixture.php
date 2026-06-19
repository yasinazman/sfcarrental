<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BookingsFixture
 */
class BookingsFixture extends TestFixture
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
                'customer_id' => 1,
                'car_id' => 1,
                'start_date' => '2026-06-19 00:02:58',
                'end_date' => '2026-06-19 00:02:58',
                'rental_price' => 1.5,
                'deposit_amount' => 1.5,
                'total_price' => 1.5,
                'booking_status' => 'Lorem ipsum dolor sit amet',
                'lockbox_pin' => 'Lorem ip',
                'deposit_status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-06-19 00:02:58',
                'modified' => '2026-06-19 00:02:58',
            ],
        ];
        parent::init();
    }
}
