<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class MaintenancesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('maintenances');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');

        // Sambungan wajib ke jadual kereta
        $this->belongsTo('Cars', [
            'foreignKey' => 'car_id',
            'joinType' => 'INNER',
        ]);
    }
}