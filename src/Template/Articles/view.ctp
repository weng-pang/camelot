<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
?>
<?php $this->assign('heading-class', 'post-heading') ?>
<?php $this->assign('heading', $article->title) ?>
<?php $this->assign('meta', "Posted on {$article->created->toFormattedDateString()}") ?>

<?php
/*
 * Intentionally don't escape this output via h($article->body), because it contains HTML which we want to display
 * to the user. Instead, we have made sure the code is safe from XSS attacks because we use HTMLPurifier to strip
 * any dangerous HTML tags before we save it to the database.
 */
?>
<article>
<?= $article->body ?>
</article>
