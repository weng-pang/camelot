<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[] $articles
 * @var string $query
 */

$this->assign('heading', "Search Results");
$this->assign('subheading', "Showing articles that match \"{$query}\"");
?>

<?= $this->Form->create(null, ['method' => 'GET']) ?>
    <!--
    Chose not to use $this->Form->control(...) because the style required for this search box is too custom.
    Also, because it is not a CRUD form, we don't need to benefit from the way in which the FormHelper automatically
    validates data, shows error messages, etc.
    -->
    <div class="input-group mb-3">
        <input type="text" name="query" class="form-control" placeholder="Enter search terms..." value="<?= h($query) ?>">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Search Again</button>
        </div>
    </div>

<?= $this->Form->end() ?>

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
