<?php
/*
 * What page is the user currently viewing? We need to know this so that we can highlight the correct menu item,
 * to provide visual feedback to the user about where they are in the website.
 */
$currentController = $this->request->getParam('controller');
$currentAction = $this->request->getParam('action');

$isDashboardActive  = $currentController === 'Admin' && $currentAction === 'index';
$isEnquiriesActive  = $currentController === 'Enquiries';
$isProductsActive  = $currentController === 'Products';
$isContentActive  = $currentController === 'Articles';
$isTagsActive  = $currentController === 'Tags';
$isUsersActive  = $currentController === 'Users';
$isSettingsActive  = $currentController === 'Admin' && $currentAction === 'settings';
?>

<nav class="menu">
    <ul class="sidebar-menu metismenu" id="sidebar-menu">
        <li class="<?= $isDashboardActive ? 'active' : '' ?>">
            <?= $this->Html->link(
                    '<i class="fa fa-home"></i> Dashboard',
                    ['controller' => 'admin'],
                    ['escape' => false]
            ) ?>
        </li>
        <li class="<?= $isEnquiriesActive ? 'active open' : '' ?>">
            <?= $this->Html->link(
                '<i class="fa fa-envelope"></i> Enquiries <i class="fa arrow"></i>',
                ['controller' => 'enquiries'],
                ['escape' => false]
            ) ?>
            <ul class="sidebar-nav">
                <li><?= $this->Html->link('View open enquiries', ['controller' => 'enquiries']) ?></li>
                <li><?= $this->Html->link('View closed enquiries', ['controller' => 'enquiries', 'action' => 'closed_enquiries']) ?></li>
            </ul>
        </li>
        <li class="<?= $isProductsActive ? 'active open' : '' ?>">
            <?= $this->Html->link(
                '<i class="fa fa-cube"></i> Products <i class="fa arrow"></i>',
                ['controller' => 'products'],
                ['escape' => false]
            ) ?>
            <ul class="sidebar-nav">
                <li><?= $this->Html->link('View products', ['controller' => 'products']) ?></li>
                <li><?= $this->Html->link('View products archive', ['controller' => 'products', 'action' => 'archiveIndex']) ?></li>
                <li><?= $this->Html->link('Manage categories', ['controller' => 'categories']) ?></li>
            </ul>
        </li>
        <li class="<?= $isContentActive ? 'active open' : '' ?>">
            <?= $this->Html->link(
                    '<i class="fa fa-file"></i> Content <i class="fa arrow"></i>',
                    ['controller' => 'articles'],
                    ['escape' => false]
            ) ?>
            <ul class="sidebar-nav">
                <li><?= $this->Html->link('View articles', ['controller' => 'articles']) ?></li>
                <li><?= $this->Html->link('View articles archive', ['controller' => 'articles', 'action' => 'archiveIndex']) ?></li>
            </ul>
        </li>
        <li class="<?= $isTagsActive ? 'active' : '' ?>">
            <?= $this->Html->link(
                    '<i class="fa fa-tag"></i> Tags',
                    ['controller' => 'tags'],
                    ['escape' => false]
            ) ?>
        </li>
        <li class="<?= $isUsersActive ? 'active open' : '' ?>">
            <?= $this->Html->link(
                    '<i class="fa fa-user"></i> Users <i class="fa arrow"></i>',
                    ['controller' => 'users'],
                    ['escape' => false]
            ) ?>
            <ul class="sidebar-nav">
                <li><?= $this->Html->link('View users', ['controller' => 'users']) ?></li>
                <li><?= $this->Html->link('Add new user', ['controller' => 'users', 'action' => 'add']) ?></li>
            </ul>
        </li>
        <li class="<?= $isSettingsActive ? 'active' : '' ?>">
            <?= $this->Html->link(
                '<i class="fa fa-cog"></i> Settings',
                ['controller' => 'admin', 'action' => 'settings'],
                ['escape' => false]
            ) ?>
        </li>
    </ul>
</nav>