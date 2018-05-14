<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
?>
<?php $this->assign('heading-class', 'post-heading') ?>
<?php $this->assign('heading', $article->title) ?>
<?php $this->assign('meta', "Posted on {$article->created->toFormattedDateString()}") ?>

<?= $article->body ?>