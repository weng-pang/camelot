<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<h1>Users</h1>

<div>
    <?= $this->Html->link('Add User', ['action' => 'add'], ['class' => 'btn btn-oval btn-primary']) ?>
</div>

<div class="card card-block">

    <table class="table">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('mobile_phone', 'Mobile') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Html->link($user->email, ['action' => 'view', $user->id], []) ?></td>
                <td><?= h($user->mobile_phone) ?></td>
                <td><?= h($user->created->nice()) ?></td>
                <td><?= h($user->modified->timeAgoInWords()) ?></td>
                <td class="action-col">
                    <?= $this->element('Admin/Buttons/edit', ['url' => ['action' => 'edit', $user->id]]) ?>
                    <?= $this->element('Admin/Buttons/delete', ['url' => ['action' => 'delete', $user->id]]) ?>
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
