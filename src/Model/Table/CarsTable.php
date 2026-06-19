<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cars Model
 *
 * @property \App\Model\Table\BookingsTable&\Cake\ORM\Association\HasMany $Bookings
 *
 * @method \App\Model\Entity\Car newEmptyEntity()
 * @method \App\Model\Entity\Car newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Car> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Car get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Car findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Car patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Car> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Car|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Car saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Car>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Car>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Car>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Car> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Car>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Car>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Car>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Car> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CarsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('cars');
        $this->setDisplayField('plate_number');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Bookings', [
            'foreignKey' => 'car_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('plate_number')
            ->maxLength('plate_number', 20)
            ->requirePresence('plate_number', 'create')
            ->notEmptyString('plate_number');

        $validator
            ->scalar('car_model')
            ->maxLength('car_model', 100)
            ->requirePresence('car_model', 'create')
            ->notEmptyString('car_model');

        $validator
            ->scalar('engine_capacity')
            ->maxLength('engine_capacity', 50)
            ->allowEmptyString('engine_capacity');

        $validator
            ->decimal('daily_rate')
            ->requirePresence('daily_rate', 'create')
            ->notEmptyString('daily_rate');

        $validator
            ->scalar('availability_status')
            ->maxLength('availability_status', 50)
            ->allowEmptyString('availability_status');

        return $validator;
    }
}
