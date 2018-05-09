<?php
/**
 * @var \App\View\AppView $this
 * @var array[] $popularArticles
 */
?>
<div class="title-block">
    <div class="title">Popular articles</div>
    <div class="title-description">Top three most viewed articles on the website.</div>
</div>

<div class="row">
    <?php foreach ($popularArticles as $article): ?>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title">
                            <?= h($article['title']) ?>
                        </p>
                        <p class="title-description">
                            Viewed <?= $this->Number->format($article['views']) ?> time<?= $article['views'] == 1 ? '' : 's' ?>
                        </p>
                    </div>
                </div>
                <div class="card-block">
                    <?= h($article['body']) ?>
                </div>
                <div class="card-footer">
                    <?= $this->element('Admin/Buttons/view', ['url' => ['controller' => 'articles', 'action' => 'view', $article['slug']]]) ?>
                    <?= $this->element('Admin/Buttons/edit', ['url' => ['controller' => 'articles', 'action' => 'edit', $article['slug']]]) ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>