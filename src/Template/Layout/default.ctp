<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>IE CMS</title>

    <!-- Bootstrap core CSS -->
    <?= $this->Html->css('lib/bootstrap.min.css') ?>

    <!-- Custom fonts for this template -->
    <?= $this->Html->css('lib/font-awesome/css/fontawesome-all.min.css') ?>
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <?= $this->Html->css('lib/template/public/clean-blog.min.css') ?>
    <?= $this->Html->css('home.css') ?>

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <?= $this->Html->link('Home', ['controller' => 'home', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <?php if ($this->request->getSession()->read('Auth.User')): ?>
                    <li class="nav-item">
                        <?= $this->Html->link('Admin', ['controller' => 'admin', 'action' => 'index'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link(
                            $this->request->getSession()->read('Auth.User.email'),
                            ['controller' => 'users', 'action' => 'edit', $this->request->getSession()->read('Auth.User.id')],
                            ['class' => 'nav-link'])
                        ?>
                    </li>
                    <li class="nav-item">
                        <?= $this->Html->link('Logout', ['controller' => 'users', 'action' => 'logout'], ['class' => 'nav-link']) ?>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <?= $this->Html->link('Login', ['controller' => 'users', 'action' => 'login'], ['class' => 'nav-link']) ?>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Header -->
<header class="masthead" style="background-image: url('/img/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="<?= $this->fetch('heading-class', 'page-heading') ?>">
                    <h1><?= $this->fetch('heading') ?></h1>
                    <?php if ($this->fetch('subheading')): ?>
                        <h2 class="subheading"><?= $this->fetch('subheading') ?></h2>
                    <?php endif ?>
                    <?php if ($this->fetch('meta')): ?>
                        <span class="meta"><?= $this->fetch('meta') ?></span>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            <?= $this->fetch('content') ?>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <p class="copyright text-muted">
                    <?= $this->element('page-source') ?>
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<?= $this->Html->script('lib/jquery-3.3.1.min.js') ?>
<?= $this->Html->script('lib/bootstrap.js') ?>

<!-- Custom scripts for this template -->
<?= $this->Html->script('lib/template/public/clean-blog.min.js') ?>

</body>

</html>