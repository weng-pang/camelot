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
    <?php echo $this->Html->css('base.css'); ?>
    <?php echo $this->Html->css('admin.css'); ?>
</head>
<body>

<div class="auth">
    <div class="auth-container">
        <div class="card">
            <header class="auth-header">
                <h1 class="auth-title">IE CMS</h1>
            </header>
            <div class="auth-content">
                <?= $this->Flash->render() ?>
                <p class="text-center">LOGIN TO CONTINUE</p>
                <?php
                echo $this->Form->create(null, [
                    'id' => 'login-form',
                    'url' => ['controller' => 'Users', 'action' => 'login'],
                ]);
                ?>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="email" class="form-control underlined" name="username" id="username" placeholder="Your email address" required> </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control underlined" name="password" id="password" placeholder="Your password" required> </div>
                    <div class="form-group">
                        <label for="remember">
                            <input class="checkbox" id="remember" type="checkbox">
                            <span>Remember me</span>
                        </label>
                        <a href="reset.html" class="forgot-btn pull-right">Forgot password?</a>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Login</button>
                    </div>
                    <div class="form-group">
                        <p class="text-muted text-center">Do not have an account?
                            <a href="signup.html">Sign Up!</a>
                        </p>
                    </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
        <div class="text-center">
            <a href="index.html" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Back to dashboard </a>
        </div>
    </div>
</div>

<?php echo $this->Html->script('lib/template/admin/vendor.js'); ?>
<?php echo $this->Html->script('lib/template/admin/app.js'); ?>
</body>
</html>