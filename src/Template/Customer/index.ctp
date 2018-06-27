<?php
/**
 * @var \App\View\AppView $this
 * @var array[] $popularArticles
 * @var array[] $viewsOverTime
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
                    <?= h($this->Text->truncate(strip_tags($article['body']), 50, ['exact' => false])) ?>
                </div>
                <div class="card-footer">
                    <?= $this->element('Admin/Buttons/view', ['url' => ['controller' => 'articles', 'action' => 'view', $article['slug']]]) ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>

<!--<?php $this->end() ?> -->
