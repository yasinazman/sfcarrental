<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Customer Entity.
 *
 * @property int $id
 * @property string $full_name
 * @property string $phone_number
 * @property string $password
 * @property string|null $ic_file_path
 * @property string|null $ic_back_file_path
 * @property string|null $license_file_path
 * @property string $account_status
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class Customer extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'full_name' => true,
        'phone_number' => true,
        'password' => true,
        'ic_file_path' => true,
        'ic_back_file_path' => true,
        'license_file_path' => true,
        'account_status' => true,
        'created' => true,
        'modified' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected array $_hidden = [
        'password',
    ];

    /**
     * Auto-hash password sebelum masuk database.
     *
     * @param string $password Kata laluan asal
     * @return string|null Kata laluan yang telah di-hash
     */
    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return null;
    }
}