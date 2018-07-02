<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<div class="title-block">
    <div class="title">
        Add New Category
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
    <?= $this->Form->create($category) ?>
    <fieldset>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('image');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
