<?php
/*
 * What page is the user currently viewing? We need to know this so that we can highlight the correct menu item,
 * to provide visual feedback to the user about where they are in the website.
 */
$currentController = $this->request->getParam('controller');
$currentAction = $this->request->getParam('action');

$isDashboardActive  = $currentController === 'Admin' && $currentAction === 'index';
$isEnquiriesActive  = $currentController === 'Enquiries';
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
        <li class="<?= $isEnquiriesActive ? 'active' : '' ?>">
            <?= $this->Html->link(
                '<i class="fa fa-envelope"></i> Enquiries',
                ['controller' => 'enquiries'],
                ['escape' => false]
            ) ?>
        </li>
        <li class="<?= $isContentActive ? 'active open' : '' ?>">
            <?= $this->Html->link(
                    '<i class="fa fa-file"></i> Content <i class="fa arrow"></i>',
                    ['controller' => 'articles'],
                    ['escape' => false]
            ) ?>
            <ul class="sidebar-nav">
                <li><?= $this->Html->link('View articles', ['controller' => 'articles']) ?></li>
                <li><?= $this->Html->link('Add new article', ['controller' => 'articles', 'action' => 'add']) ?></li>
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