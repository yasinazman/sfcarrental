<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Car Entity
 *
 * @property int $id
 * @property string $plate_number
 * @property string $car_model
 * @property string|null $engine_capacity
 * @property string $daily_rate
 * @property string|null $availability_status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Booking[] $bookings
 */
class Car extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'plate_number' => true,
        'car_model' => true,
        'category' => true,
        'car_category' => true,
        'image' => true,
        'engine_capacity' => true,
        'seat_capacity' => true,
        'transmission' => true,
        'baggage_capacity' => true,
        'fuel_type' => true,
        'spare_tyre' => true,
        'special_specs' => true,
        'daily_rate' => true,
        'availability_status' => true,
        'latitude' => true,
        'longitude' => true,
        'created' => true,
        'modified' => true,
        'bookings' => true,
        'maintenances' => true,
    ];
}