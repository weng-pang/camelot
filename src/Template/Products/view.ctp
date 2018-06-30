<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<div class="title-block">
    <div class="title">
        <?= h($product->name) ?>
    </div>
</div>
<div class="card card-block">

    <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-12">
        <table class="vertical-table">
            <tr>
                <th scope="row"><?= __('Price') ?></th>
                <td><?= $this->Number->format($product->price) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Sale Price') ?></th>
                <td><?= $this->Number->format($product->sale_price) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Stock') ?></th>
                <td><?= $this->Number->format($product->stock) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($product->created) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($product->modified) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('On Sale') ?></th>
                <td><?= $product->on_sale ? __('Yes') : __('No'); ?></td>
            </tr>
            <tr>
                <th scope="row" style="float:right"><?= __('Description') ?></th>
                <td><article>
                    <?= $product->description ?>
                </article></td>
            </tr>
        </table>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <?= $this->Html->image($product->image, array('width' => '200px')); ?>
        </div>
    </div>
</div>