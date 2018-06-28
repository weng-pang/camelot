<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var array $currentUser
 */
?>
<div class="title-block">
    <div class="title">
        <?= $user->id ? 'Edit' : 'New' ?> User
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <?= $this->Form->create($user, ['id' => 'user-form']) ?>

            <div class="card-block">
                <?= $this->Form->control('name') ?>
                <?= $this->Form->control('email') ?>
                <?= $this->Form->control('password', ['value' => '', 'autocomplete' => 'off', 'required' => !$user->id]) ?>
                <?= $this->Form->control('mobile_phone') ?>
                <?= $this->Form->label('Role'); ?>
                <?= $this->Form->radio('role', [0, 1, 2, 3]); ?>
            </div>

            <div class="card-footer">
                <?= $this->Form->button(__('Save User')) ?>
                <?= $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $user->id],
                    [
                        'confirm' => ($currentUser['id'] === $user->id) ? false : __('Are you sure?'),
                        'class' => 'btn btn-delete btn-danger',
                        'disabled' => ($currentUser['id'] === $user->id)
                    ]
                )
                ?>
            </div>

            <?= $this->Form->end() ?>

        </div>
    </div>
</div>

<?php $this->start('script'); ?>
<?php
$validationRules = [
    'email' => ['required' => true, 'email' => 'true'],
];

// If editing a user, they can submit an empty password, because that means they don't want to change it.
if (!$user->id) {
    $validationRules['password'] = ['required' => true];
}
?>
<script>
    (function() {
        $("#user-form").validate({
            rules: <?= json_encode($validationRules) ?>
        });
    })();
</script>
<?php $this->end(); ?>