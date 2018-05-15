<?php
/**
 * @var \App\View\AppView $this
 * @var array $currentUser
 * @var \App\Model\Entity\Tag[]|\Cake\Collection\CollectionInterface $tags
 */
?>
<div class="title-block">
    <div class="title">
        Tags
        <?= $this->Html->link('Add Tag', ['action' => 'add'], ['class' => 'pull-right btn btn-oval btn-primary']) ?>
    </div>
</div>

<div class="card card-block">

    <table class="table">
        <thead>
        <tr>
            <th><?= $this->Paginator->sort('title') ?></th>
            <th><?= $this->Paginator->sort('created') ?></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tags as $tag): ?>
            <tr>
                <td><?= $this->Html->link($tag->title, ['action' => 'view', $tag->id]) ?></td>
                <td><?= h($tag->created->nice()) ?></td>
                <td class="action-col">
                    <?= $this->element('Admin/Buttons/edit', ['url' => ['action' => 'edit', $tag->id]]) ?>
                    <?= $this->element('Admin/Buttons/delete', ['url' => ['action' => 'delete', $tag->id]]) ?>
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
