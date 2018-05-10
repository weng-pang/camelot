<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
?>
<?php $this->assign('heading-class', 'post-heading') ?>
<?php $this->assign('heading', $article->title) ?>
<?php $this->assign('meta', "Posted on {$article->created->toFormattedDateString()}") ?>

<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <?= h($article->body) ?>
            </div>
        </div>
    </div>
</article>