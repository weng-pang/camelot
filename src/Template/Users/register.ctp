<?php
/**
 * @var \App\Model\Entity\User $user
 */
?>

<p class="text-center">Register an Account</p>
<?= $this->Form->create($user); ?>
<?= $this->Form->control('name', ['placeholder' => 'Your name', 'required']);?>
<?= $this->Form->control('email', ['placeholder' => 'Your email address', 'required']);?>
<?= $this->Form->control('mobile_phone', ['placeholder' => 'Your mobile number']);?>
<?= $this->Form->control('password', ['placeholder' => 'Your password', 'required']);?>
<div class="form-group">
    <?= $this->Html->link("Have an account already?", ['action' => 'login'], ['class' => 'forgot-btn pull-right']); ?>
</div>
<?= $this->Form->button('Register'); ?>
<?php echo $this->Form->end(); ?>
