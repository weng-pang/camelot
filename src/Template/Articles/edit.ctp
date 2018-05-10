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
<div class="row">
    <div class="col-md-9">
        <div class="card card-block">
            <div class="title-block">
                <h3 class="title"><?= $article->id ? 'Edit' : 'Add' ?> Article</h3>
            </div>

            <?php
            echo $this->Form->create($article, ['id' => 'article-form']);
            echo $this->Form->control('title');
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
