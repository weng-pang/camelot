<?php
/**
 * @var \App\View\AppView $this
 * @var array $currentUser
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="title-block">
    <div class="title">
        Users
        <?= $this->Html->link('Add User', ['action' => 'add'], ['class' => 'pull-right btn btn-oval btn-primary']) ?>
    </div>
</div>

<div class="card card-block">

    <table class="table">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Html->link($user->name, ['action' => 'edit', $user->id], []) ?></td>
                <td><?= $this->Html->link($user->email, ['mailto' => $user->email]) ?></td>
                <td><?= h($user->created->nice()) ?></td>
                <td class="action-col">
                    <?= $this->element('Admin/Buttons/edit', ['url' => ['action' => 'edit', $user->id]]) ?>
                    <?= $this->element('Admin/Buttons/delete', ['url' => ['action' => 'delete', $user->id], 'disabled' => $currentUser['id'] === $user->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($this->Paginator->hasNext() || $this->Paginator->hasPrev()): ?>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        </div>
    <?php endif ?>
</div>
