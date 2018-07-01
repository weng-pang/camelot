<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Enquiry[]|\Cake\Collection\CollectionInterface $enquiries
 */
?>
<div class="title-block">
    <div class="title">
        Closed Enquiries
    </div>
</div>
<div class="card card-block">
    <table class="table">
        <thead>
            <tr>
                <th scope="col" width = 20%><?= $this->Paginator->sort('temp_email','Email') ?></th>
                <th scope="col"><?= $this->Paginator->sort('subject') ?></th>
                <th scope="col" width = 20% ><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" width = 20% class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($archivedEnquiries as $enquiry): ?>
            <tr>
                <td><?= h($enquiry->temp_email) ?></td>
                <td><?= h($enquiry->subject) ?></td>
                <td><?= h($enquiry->created->nice()) ?></td>
                <td class="actions" width = "30%">
                    <?= $this->element('Admin/Buttons/view', ['url' => ['action' => 'view', $enquiry->id]]) ?>
                    <?= $this->element('Admin/Buttons/open', ['url' => ['action' => 'open', $enquiry->id]]) ?>
                    <?= $this->element('Admin/Buttons/delete', ['url' => ['action' => 'delete', $enquiry->id]]) ?>

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
