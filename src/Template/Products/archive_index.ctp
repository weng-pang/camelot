<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="title-block">
    <div class="title">
        Products
    </div>
</div>
<div class="card card-block">
    <table class="table">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('image') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('stock') ?></th>
                <th scope="col"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('featured') ?></th>
                <th scope="col"><?= $this->Paginator->sort('on_sale') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($archivedProducts as $product): ?>
            <tr>
                <td width = 15%> <?php if($product->image != '') { ?><?= $this->Html->image($product->image, array('width' => '100px')); ?><?php } ?></td>
                <td><?= h($product->name) ?></td>
                <td><?= $this->Number->format($product->stock) ?></td>
                <td><?= $this->Number->format($product->price) ?></td>
                <td><?= h($product->featured) ?></td>
                <td><?= h($product->on_sale) ?></td>
                <td class="actions">
                    <?= $this->element('Admin/Buttons/view', ['url' => ['action' => 'view', $product->id]]) ?>
                    <?= $this->element('Admin/Buttons/restore', ['url' => ['action' => 'restore', $product->id]]) ?>
                    <?= $this->element('Admin/Buttons/delete', ['url' => ['action' => 'delete', $product->id]]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
</div>
