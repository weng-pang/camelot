<?php

/**
 * This template works hand-in-hand with the Admin/menu-item.ctp template. This file is responsible for defining
 * all the links which need to be displayed in the menu, whereas the menu-item.ctp template is responsible for rendering
 * a specific link in the menu.
 */
$links = [
    [
        'label' => 'Dashboard',
        'controller' => 'Admin',
        'action' => 'index',
        'icon' => 'home',
    ],
    [
        'label' => 'Content',
        'icon' => 'file',
        'controller' => 'Articles',
        'action' => 'index',
        'children' => [
            [
                'label' => 'View content',
                'controller' => 'Articles',
                'action' => 'index',
            ],
            [
                'label' => 'Add content',
                'controller' => 'Articles',
                'action' => 'add',
            ],
        ]
    ],
    [
        'label' => 'Users',
        'icon' => 'user',
        'controller' => 'Users',
        'action' => 'index',
        'children' => [
            [
                'label' => 'View users',
                'controller' => 'Users',
                'action' => 'index',
            ],
            [
                'label' => 'Add user',
                'controller' => 'Users',
                'action' => 'add',
            ],
        ]
    ],
]
?>

<nav class="menu">
    <ul class="sidebar-menu metismenu" id="sidebar-menu">
        <?php
        foreach($links as $link) {
            echo $this->element('Admin/menu-item', $link);
        }
        ?>
    </ul>
</nav>