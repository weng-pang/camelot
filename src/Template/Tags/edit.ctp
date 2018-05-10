<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title">
                            <?= $tag->id ? 'Edit' : 'Add' ?> Tag
                        </p>
                    </div>
                </div>

                <?= $this->Form->create($tag, ['id' => 'tag-form']) ?>

                <div class="card-block">
                    <?= $this->Form->control('title') ?>
                </div>

                <div class="card-footer">
                    <?= $this->Form->button(__('Save Tag')) ?>
                    <?= $this->Form->postLink(
                        __('Delete'),
                        ['action' => 'delete', $tag->id],
                        [
                            'confirm' => __('Are you sure?'),
                            'class' => 'btn btn-delete btn-danger',
                        ]
                    )
                    ?>
                </div>

                <?= $this->Form->end() ?>

            </div>
        </div>
    </div>

<?php $this->start('script'); ?>
    <script>
        (function() {
            $("#tag-form").validate({
                rules: { title: 'required' }
            });
        })();
    </script>
<?php $this->end(); ?>