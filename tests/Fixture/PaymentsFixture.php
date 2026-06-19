<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PaymentsFixture
 */
class PaymentsFixture extends TestFixture
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
                'booking_id' => 1,
                'payment_time' => '2026-06-19 00:03:23',
                'total_payment' => 1.5,
                'payment_method' => 'Lorem ipsum dolor sit amet',
                'payment_status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-06-19 00:03:23',
                'modified' => '2026-06-19 00:03:23',
            ],
        ];
        parent::init();
    }
}
