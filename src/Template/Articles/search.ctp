<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[] $articles
 * @var string[] $tagList
 * @var string $query
 * @var int $selectedTagId
 */

$this->assign('heading', "Search Results");
$this->assign('heading-class', "page-heading compact-page-heading");
$this->assign('subheading', "Showing articles that match \"{$query}\"");
?>

<div class="large-search-wrapper">
    <?= $this->Form->create(null, ['url' => ['controller' => 'articles', 'action' => 'advancedSearch'], 'method' => 'GET']) ?>
        <div class="row">
            <div class="col-lg-9">
                <?= $this->Form->control('query', ['label' => 'Search terms', 'class' => 'form-control', 'value' => $query]) ?>
            </div>
            <div class="col-lg-3">
                <?= $this->Form->control('tag', ['class' => 'form-control', 'options' => $tagList, 'empty' => 'Select a tag...', 'value' => $selectedTagId]) ?>
            </div>
        </div>
        <?= $this->Form->button('Search', ['type' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>

<?php
foreach($articles as $article) {
    echo $this->element('article-snippet', ['article' => $article]);
}
?>

<!-- Pager -->
<div class="clearfix">
    <?= $this->Paginator->prev() ?>
    <?= $this->Paginator->next() ?>
</div>
