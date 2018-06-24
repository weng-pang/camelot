<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Enquiry $enquiry
 */
?>
<div class="title-block">
    <div class="title">
        Enquiry sent in on <i><?= h($enquiry->created->nice()) ?></i>
    </div>
</div>
<div class="card card-block">
    <table class="vertical-table">

        <tr>
            <th scope="row" width="10%"><?= __('Subject') ?></th>
            <td><?= h($enquiry->subject) ?></td>
        </tr>
        <tr>
            <th scope="row" width="10%"><?= __('Body') ?></th>
            <td><?= h($enquiry->body) ?></td>
        </tr>

    </table>
</div>
