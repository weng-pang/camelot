<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<div class="title-block">
    <div class="title">
        Edit <?= $product->name?>
            <span class="pull-right">
                <?php if ($product->archived) { ?>
                    <?= $this->element('Admin/Buttons/view', ['url' => ['action' => 'view', $product->id]]) ?>
                    <?= $this->element('Admin/Buttons/restore', ['url' => ['action' => 'restore', $product->id]]) ?>
                <?php } else {?>
                    <?= $this->element('Admin/Buttons/view', ['url' => ['action' => 'view', $product->id]]) ?>
                    <?= $this->element('Admin/Buttons/archive', ['url' => ['action' => 'archive', $product->id]]) ?>
                <?php } ?>
            </span>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
    <?= $this->Form->create($product) ?>
    <fieldset>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('image');
            echo $this->Form->control('price');
            echo $this->Form->control('sale_price');
            echo $this->Form->control('stock');
            echo $this->Form->control('on_sale');
            echo $this->Form->control('featured');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
