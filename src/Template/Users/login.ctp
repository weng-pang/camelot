<?php
/**
 * @var \App\Model\Entity\Settings $settings
 */
?>

<p class="login-box-msg text-center">Login to continue</p>
<?= $this->Form->create(
    null,
    [
        'id' => 'login-form',
        'url' => [
            'controller' => 'Users',
            'action' => 'login',
            '?' => [
                'redirect' => $this->request->getQuery('redirect')
            ]
        ]
    ]); ?>
<?= $this->Form->control('email', ['placeholder' => 'Your email address', 'required', 'value' => $settings->is_demo_site ? 'root@example.com' : '']);?>
<?= $this->Form->control('password', ['placeholder' => 'Your password', 'required', 'value' => $settings->is_demo_site ? 'demo password' : '']);?>
<?= $this->Form->control('remember', ['type' => "checkbox", 'label' => "Remember Me", 'hiddenField' => false]); ?>
<div class="form-group">
    <?= $this->Html->link("New to Camelot? Register!", ['action' => 'register'], ['class' => 'btn forgot-btn pull-right']); ?>
    <!-- <?= $this->Html->link("Forgot password?", ['action' => 'resetPassword'], ['class' => 'forgot-btn pull-right']); ?> -->
</div>
<?= $this->Form->button(__('Login',['type'=>'button','class'=>'btn-success'])); ?>
<?php echo $this->Form->end(); ?>
