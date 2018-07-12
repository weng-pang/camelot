<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[] $articles
 */
?>

<div class="title-block">
    <div class="title">
        Articles
        <?= $this->Html->link('Add Article', ['action' => 'add'], ['class' => 'pull-right btn btn-oval btn-primary']) ?>
    </div>
</div>

<div class="card card-block">

    <table class="articles-table table">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr class="article-row <?= $article->published ? 'published' : 'unpublished' ?>">
                    <td style="width: 40%">
                        <?= $this->Html->link($article->title, ['action' => 'edit', $article->slug]) ?>
                    </td>
                    <td>
                        <?= $article->created->timeAgoInWords() ?>
                    </td>
                    <td class="action-col">
                        <?php if ($article->published) { ?>
                        <?= $this->element('Admin/Buttons/view', ['url' => ['action' => 'view', $article->slug]]) ?>
                        <?= $this->element('Admin/Buttons/edit', ['url' => ['action' => 'edit', $article->slug]]) ?>
                        <?= $this->element('Admin/Buttons/hide', ['url' => ['action' => 'hide', $article->id]]) ?>
                            <?= $this->element('Admin/Buttons/archive', ['url' => ['action' => 'archive', $article->id]]) ?>
                        <?php } else {?>
                        <?= $this->element('Admin/Buttons/preview', ['url' => ['action' => 'view', $article->slug]]) ?>
                        <?= $this->element('Admin/Buttons/edit', ['url' => ['action' => 'edit', $article->slug]]) ?>
                        <?= $this->element('Admin/Buttons/publish', ['url' => ['action' => 'publish', $article->id]]) ?>
                            <?= $this->element('Admin/Buttons/archive', ['url' => ['action' => 'archive', $article->id]]) ?>
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
