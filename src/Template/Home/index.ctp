<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[] $articles
 * @var \App\Model\Entity\Settings $settings
 */

$this->assign('heading', $settings->title);
$this->assign('subheading', $settings->subtitle);

foreach($articles as $article) {
    echo $this->element('article-snippet', ['article' => $article]);
}
?>

<!-- Pager -->
<div class="clearfix">
    <?= $this->Paginator->prev() ?>
    <?= $this->Paginator->next() ?>
</div>
