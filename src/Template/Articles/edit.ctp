<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 * @var array[] $tags
 */
?>
<style>
    .manage-tags {
        margin-left: 10px;
    }
</style>

<div class="title-block">
    <div class="title">
        <?= $article->isNew() ? 'New' : 'Edit' ?> Article
        <?php if (!$article->isNew()): ?>
            <span class="pull-right">
                <?php if ($article->published) { ?>
                <?= $this->element('Admin/Buttons/hide', ['url' => ['action' => 'hide', $article->id]]) ?>
                    <?= $this->element('Admin/Buttons/view', ['url' => ['action' => 'view', $article->slug]]) ?>
                <?php } else {?>
                <?= $this->element('Admin/Buttons/publish', ['url' => ['action' => 'publish', $article->id]]) ?>
                    <?= $this->element('Admin/Buttons/preview', ['url' => ['action' => 'view', $article->slug]]) ?>
                <?php } ?>
            </span>
        <?php endif ?>
    </div>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="card card-block">
            <?php
            echo $this->Form->create($article, ['id' => 'article-form']);
            echo $this->Form->control('title');
            if (!$article->isNew()) {
                // Don't prompt the user to enter a slug when first creating the article. We will create one
                // automatically in the Controller or Model. However, once the article is created, it may be
                // desirable for the user to change the slug.
                echo $this->Form->control('slug');
            }
            echo $this->Form->control('body', ['rows' => '10']);
            echo $this->Form->control('tags._ids', ['options' => $tags]);
            echo $this->Form->button(__('Save Article'));

            // "target" => "_blank" will mean that clicking the button will open a new tab.
            // I don't like doing this, because I think users are best placed to decide fi they want a new tab or not.
            // However, here they may spend a long time writing an article, then click "Manage Tags" and I don't want
            // them to accidentally lose their work by navigating to a different screen.
            echo $this->Html->link('Manage tags', ['controller' => 'tags'], ['class' => 'btn btn-sm btn-oval manage-tags btn-secondary', 'target' => '_blank']);
            echo $this->Form->end();
            ?>

        </div>
    </div>
</div>

<?php $this->start('script'); ?>
<script>
    (function() {
        $("#article-form").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 10
                },
                body: {
                    required: true,
                    minlength: 10,
                },
            }
        });
    })();
</script>
<?php $this->end(); ?>
