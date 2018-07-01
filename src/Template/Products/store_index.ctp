<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>

<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-block">
                        <h1>$<?= $this->Number->format($product->price) ?></h1>
                    </div>
                    <div class="header-block">
                        <p class="title">
                            <?= $this->Html->image($product->image, array('height' => '180px')); ?>
                            <h5><?= h($product['name']) ?></h5>
                        </p>
                        <p class="title-description">
                            Featured
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