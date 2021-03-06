<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Enquiry Entity
 *
 * @property int $id
 * @property string $subject
 * @property string $body
 * @property \Cake\I18n\FrozenTime $created
 */
class Enquiry extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'subject' => true,
        'body' => true,
        'created' => true,
        'temp_email' => true,
    ];

    /**
     * If this user created this enquiry, then they are allowed to access it.
     * Also, admin users can access all enquiries.
     * @param $user
     * @return bool True if the $user is allowed to access the enquiry.
     */
    public function canAccess($user) {
        return Role::isAdmin($user['role']) || $this->user_id == $user['id'];
    }
}
