<?php
/**
 * @var \App\Model\Entity\Settings $settings
 */

$this->Form->setTemplates(\Cake\Core\Configure::read('FormTemplates.Admin'));
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $this->fetch('title'); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo $this->Html->css('lib/template/admin/vendor.css'); ?>
    <?php echo $this->Html->css('lib/template/admin/app.css'); ?>
    <?php echo $this->Html->css('lib/chosen.min.css'); ?>
    <?php echo $this->Html->css('admin.css'); ?>
</head>
<body>

<div class="main-wrapper">
    <div class="app" id="app">
        <header class="header">
            <div class="header-block header-block-collapse d-lg-none d-xl-none">
                <button class="collapse-btn" id="sidebar-collapse-btn">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="header-block header-block-search">
            </div>
            <div class="header-block header-block-buttons">
            </div>
            <div class="header-block header-block-nav">
                <ul class="nav-profile">
                    <li class="profile dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="name"> <?= $this->request->getSession()->read('Auth.User.name'); ?></span>
                        </a>
                        <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="dropdownMenu1">
                            <?= $this->Html->link(
                                    '<i class="fa fa-power-off icon"></i> Logout',
                                    ['controller' => 'users', 'action' => 'logout'],
                                    ['class' => 'dropdown-item', 'escape' => false]
                            );?>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
        <aside class="sidebar">
            <div class="sidebar-container">
                <div class="sidebar-header">
                    <div class="brand">
                        <?= $this->Html->link($settings->title, ['controller' => 'home']) ?>
                    </div>
                </div>
                <?= $this->element('Customer/menu'); ?>
            </div>
            <footer class="sidebar-footer">
            </footer>
        </aside>
        <div class="sidebar-mobile-menu-handle" id="sidebar-mobile-menu-handle"></div>
        <div class="mobile-menu-handle"></div>

        <article class="content dashboard-page">
            <?= $this->Flash->render(); ?>
            <?= $this->fetch('content'); ?>
        </article>
        <footer class="footer">
            <div class="footer-block">
                <?= $this->element('page-source') ?>
            </div>
        </footer>
    </div>
</div>


<?php echo $this->Html->script('lib/template/admin/vendor.js'); ?>
<?php echo $this->Html->script('lib/template/admin/app.js'); ?>
<?php echo $this->Html->script('lib/jquery.validate.min.js'); ?>
<?php echo $this->Html->script('lib/chosen.jquery.min.js'); ?>
<?php echo $this->Html->script('lib/tinymce/tinymce.min.js'); ?>
<?php echo $this->fetch('script'); ?>

</body>
</html>