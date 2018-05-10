<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[] $articles
 * @var \App\Model\Entity\Settings $settings
 */
?>
<?php $this->assign('heading', $settings->title) ?>
<?php $this->assign('subheading', $settings->subtitle) ?>
<?php foreach($articles as $article): ?>
    <div class="post-preview">
        <a href="<?= $this->Url->build(['controller' => 'articles', 'action' => 'view', $article->slug]) ?>">
            <h2 class="post-title">
                <?= h($article->title) ?>
            </h2>
            <?php if ($article->subtitle): ?>
                <h3 class="post-subtitle">
                    <?= h($article->subtitle) ?>
                </h3>
            <?php endif ?>
        </a>
        <p>
            <?= h($this->Text->truncate($article['body'], 250, ['exact' => false])) ?>
        </p>
        <p class="post-meta">Posted on <?= h($article->created->toFormattedDateString()) ?></p>
    </div>
    <hr>
<?php endforeach ?>

<!-- Pager -->
<div class="clearfix">
    <?= $this->Paginator->prev() ?>
    <?= $this->Paginator->next() ?>
</div>
