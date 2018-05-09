<?php
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
    <?php echo $this->Html->css('base.css'); ?>
    <?php echo $this->Html->css('admin.css'); ?>
</head>
<body>

<div class="auth">
    <div class="auth-container">
        <div class="card">
            <header class="auth-header">
                <h1 class="auth-title">
                    <?= $this->Html->link('IE CMS', ['controller' => 'Home', 'action' => 'index']);?>
                </h1>
            </header>
            <div class="auth-content">

                <?= $this->Flash->render() ?>

                <p class="text-center">LOGIN TO CONTINUE</p>

                <?= $this->Form->create(null, ['id' => 'login-form', 'url' => ['controller' => 'Users', 'action' => 'login']]); ?>
                <?= $this->Form->control('email', ['placeholder' => 'Your email address', 'required']);?>
                <?= $this->Form->control('password', ['placeholder' => 'Your password', 'required']);?>
                <?= $this->Form->control('remember', ['type' => "checkbox", 'label' => "Remember Me", 'hiddenField' => false]); ?>
                <div class="form-group">
                    <?= $this->Html->link("Forgot password?", ['action' => 'resetPassword'], ['class' => 'forgot-btn pull-right']); ?>
                </div>
                <?= $this->Form->submit('Login'); ?>
                <div class="form-group">
                    <p class="text-muted text-center">Do not have an account?
                        <?= $this->Html->link('Sign Up!', ['action' => 'create']); ?>
                    </p>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
        <div class="text-center">
            <?= $this->Html->link('<i class="fa fa-arrow-left"></i> Home', ['controller' => 'Home', 'action' => 'index'], ['class' => 'btn btn-secondary btn-sm', 'escape' => false]); ?>
        </div>
    </div>
</div>

<?php echo $this->Html->script('lib/template/admin/vendor.js'); ?>
<?php echo $this->Html->script('lib/template/admin/app.js'); ?>
</body>
</html>