<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<div class="title-block">
    <div class="title">
        <?= h($category->name) ?>
    </div>
</div>
<div class="card card-block">

    <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-12">
            <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($category->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Image') ?></th>
            <td><?= h($category->image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($category->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($category->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($category->modified) ?></td>
        </tr>
    </table>
        </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <?= $this->Html->image($category->image, array('width' => '200px')); ?>
            </div>
    </div>
</div>
