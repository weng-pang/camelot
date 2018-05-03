
<h1 class="my-4">CMS Articles
    <small></small>
</h1>

<?php foreach($articles as $article): ?>
    <div class="card mb-4">
        <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
        <div class="card-body">
            <h2 class="card-title"><?= h($article->title) ?></h2>
            <p class="card-text"><?= h($article->body) ?></p>
            <a href="#" class="btn btn-primary">Read More &rarr;</a>
        </div>
        <div class="card-footer text-muted">
            Posted on <?= h($article->created) ?>
        </div>
    </div>
<?php endforeach ?>

<!-- Pagination -->
<ul class="pagination justify-content-center mb-4">
    <!-- Because we are sorting in reverse-chronological order, the "Previous" page is actually the newer page and vice-verca -->
    <?= $this->Paginator->prev('Newer') ?>
    <?= $this->Paginator->next('Older') ?>
</ul>
