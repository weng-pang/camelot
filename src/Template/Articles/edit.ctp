<div class="row">
    <div class="col-md-6">
        <div class="card card-block">
            <div class="title-block">
                <h3 class="title"><?= $article->id ? 'Edit' : 'Add' ?> Article</h3>
            </div>

            <?php
            echo $this->Form->create($article, ['id' => 'article-form']);
            echo $this->Form->control('title');
            echo $this->Form->control('body', ['rows' => '3']);
            echo $this->Form->control('tag_string', ['type' => 'text', 'label' => 'Tags (comma separated)']);
            echo $this->Form->button(__('Save Article'));
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
