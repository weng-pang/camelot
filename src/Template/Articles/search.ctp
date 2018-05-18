<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[] $articles
 * @var string $query
 */

$this->assign('heading', "Search Results");
$this->assign('subheading', "Showing articles that match \"{$query}\"");

foreach($articles as $article) {
    echo $this->element('article-snippet', ['article' => $article]);
}
?>

<!-- Pager -->
<div class="clearfix">
    <?= $this->Paginator->prev() ?>
    <?= $this->Paginator->next() ?>
</div>
