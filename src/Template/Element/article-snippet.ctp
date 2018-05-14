<?php
/**
 * @var \App\Model\Entity\Article $article
 */
?>

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
        <?= $this->Text->truncate($article['body'], 250, ['exact' => false]) ?>
    </p>
    <p class="post-meta">Posted on <?= h($article->created->toFormattedDateString()) ?></p>
</div>
<hr>