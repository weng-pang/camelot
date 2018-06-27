<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Enquiry $enquiry
 */
?>
<?= $this->Flash->render(); ?>
<div class="enquiries form large-9 medium-8 columns content">
    <?= $this->Form->create($enquiry) ?>
    <fieldset>
        <legend style = "text-align: center"><?= __('Send Enquiry') ?></legend>
        <?php
            echo $this->Form->control('temp_email', array('required' => true));
            echo $this->Form->control('subject', array('required' => true));
            echo $this->Form->control('body', array('required' => true, 'rows' => 8));
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
