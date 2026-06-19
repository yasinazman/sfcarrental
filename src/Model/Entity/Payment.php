<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property int $id
 * @property int $booking_id
 * @property \Cake\I18n\DateTime|null $payment_time
 * @property string $total_payment
 * @property string|null $payment_method
 * @property string|null $payment_status
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Booking $booking
 */
class Payment extends Entity
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
        'booking_id' => true,
        'payment_time' => true,
        'total_payment' => true,
        'payment_method' => true,
        'payment_status' => true,
        'created' => true,
        'modified' => true,
        'booking' => true,
    ];
}
