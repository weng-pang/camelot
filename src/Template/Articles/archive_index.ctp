<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[] $articles
 */
?>

<div class="title-block">
    <div class="title">
        Articles Archive
    </div>
</div>

<div class="card card-block">

    <table class="table">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($archivedArticles as $article): ?>
                <tr>
                    <td style="width: 40%">
                        <?= $this->Html->link($article->title, ['action' => 'edit', $article->slug]) ?>
                    </td>
                    <td>
                        <?= $article->created->timeAgoInWords() ?>
                    </td>
                    <td class="action-col">
                        <?= $this->element('Admin/Buttons/view', ['url' => ['action' => 'view', $article->slug]]) ?>
                        <?= $this->element('Admin/Buttons/restore', ['url' => ['action' => 'restore', $article->id]]) ?>
                        <?= $this->element('Admin/Buttons/delete', ['url' => ['action' => 'delete', $article->slug]]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

