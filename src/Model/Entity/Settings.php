<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Settings Entity
 *
 * @property int $id
 * @property string $title
 * @property string $subtitle
 */
class Settings extends Entity
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
        'title' => true,
        'subtitle' => true,
        'background_image' => true,
    ];

    protected function _getBackgroundImageUrl()
    {
        $image_path = "/files/Settings/background_image/{$this->background_image}";
        if (!file_exists(WWW_ROOT . $image_path)) {
            $image_path = '/img/home-bg.jpg';
        }

        return \Cake\Routing\Router::url($image_path);
    }
}
