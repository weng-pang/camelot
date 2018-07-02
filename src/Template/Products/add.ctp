<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<div class="title-block">
    <div class="title">
        Add New Product
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="indicatorDefault">
                * Indicates required field
            </div>
            <?= $this->Form->create($product) ?>
            <?php
            echo $this->Form->control('category_id', ['options' => $categories, 'label' => 'Category *']);
            echo $this->Form->control('name', array('label' => 'Name *'));
            echo $this->Form->control('description');
            ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <?php
            echo $this->Form->control('image');
            echo $this->Form->control('price', array('label' => 'Price *'));
            echo $this->Form->control('sale_price');
            echo $this->Form->control('stock', array('label' => 'Stock *'));
            ?>
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <?php echo $this->Form->control('on_sale'); ?>
                </div>
                <div class="col-md-4 col-sm-4">
                    <?php echo $this->Form->control('featured'); ?>
                </div>
                <div class="col-md-4 col-sm-4">
                    <?php echo $this->Form->control('archived'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div style="text-align: center"><?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

