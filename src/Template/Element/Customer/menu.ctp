<?php
/*
 * What page is the user currently viewing? We need to know this so that we can highlight the correct menu item,
 * to provide visual feedback to the user about where they are in the website.
 */
$currentController = $this->request->getParam('controller');
$currentAction = $this->request->getParam('action');

$isDashboardActive  = $currentController === 'Customer' && $currentAction === 'index';
$isEnquiriesActive  = $currentController === 'Enquiries';
?>

<nav class="menu">
    <ul class="sidebar-menu metismenu" id="sidebar-menu">
        <li class="<?= $isDashboardActive ? 'active' : '' ?>">
            <?= $this->Html->link(
                    '<i class="fa fa-home"></i> Dashboard',
                    ['controller' => 'customer'],
                    ['escape' => false]
            ) ?>
        </li>
        <li class="<?= $isEnquiriesActive ? 'active' : '' ?>">
            <?= $this->Html->link(
                '<i class="fa fa-envelope"></i> Enquiries',
                ['controller' => 'enquiries', 'action' => 'myEnquiries'],
                ['escape' => false]
            ) ?>
        </li>
    </ul>
</nav>