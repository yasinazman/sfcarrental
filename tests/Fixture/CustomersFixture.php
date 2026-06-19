<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CustomersFixture
 */
class CustomersFixture extends TestFixture
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
                'full_name' => 'Lorem ipsum dolor sit amet',
                'phone_number' => 'Lorem ipsum dolor ',
                'password' => 'Lorem ipsum dolor sit amet',
                'ic_file_path' => 'Lorem ipsum dolor sit amet',
                'license_file_path' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-06-18 23:58:14',
                'modified' => '2026-06-18 23:58:14',
            ],
        ];
        parent::init();
    }
}
