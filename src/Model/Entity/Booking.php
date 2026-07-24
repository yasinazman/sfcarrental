<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Booking Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property int $car_id
 * @property \Cake\I18n\DateTime $start_date
 * @property \Cake\I18n\DateTime $end_date
 * @property string $rental_price
 * @property string|null $deposit_amount
 * @property string $total_price
 * @property string|null $booking_status
 * @property string|null $lockbox_pin
 * @property string|null $deposit_status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $destination
 * @property string|null $pickup_location
 * @property string|null $dropoff_location
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Car $car
 * @property \App\Model\Entity\Payment[] $payments
 */
class Booking extends Entity
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
        'customer_id' => true,
        'car_id' => true,
        'start_date' => true,
        'end_date' => true,
        'rental_price' => true,
        'deposit_amount' => true,
        'total_price' => true,
        'booking_status' => true,
        'lockbox_pin' => true,
        'deposit_status' => true,
        'destination' => true,
        'pickup_location' => true,
        'dropoff_location' => true,
        'modified' => true,
        'customer' => true,
        'car' => true,
        'payments' => true,
    ];
}