<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>

<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-xl-4 col-md-6">
            <div class="card" <?php if ($product->featured) {?>style="border-color:#b64eff;border-width:3px;"<?php } ?>>
                <div class="card-header">
                    <div class="card-block">
                        <?php if ($product->on_sale) {?>
                            <h1><strike>$<?= $this->Number->format($product->price) ?></strike><span style ="color:red"> $<?= $this->Number->format($product->sale_price) ?></span></h1>
                        <?php } else {?>
                            <h1>$<?= $this->Number->format($product->price) ?></h1>
                        <?php } ?>
                    </div>
                    <div class="header-block">
                        <p class="title" style="text-align: center">

                            <?= $this->Html->image($product->image, array('height' => '180px')); ?>
                            <h5><?= h($product['name']) ?></h5>
                        </p>
                        <p class="title-description">
                            <?php if ($product->featured) { ?>Featured<?php } else {?> Not Featured<?php } ?>
                        </p>
                    </div>
                </div>

                <!-- <div class="card-footer">
                    <?= $this->element('Admin/Buttons/view', ['url' => ['action' => 'view', $product->id]]) ?>
                </div>-->
            </div>
        </div>
    <?php endforeach ?>
</div>

<!-- <td><?= $this->Number->format($product->price) ?></td>
<td><?= h($product->featured)?'yes':'no' ?></td>
<td><?= h($product->on_sale)?'yes':'no' ?></td> -->