<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Settings $settings
 */
?>
<div class="row">
    <div class="col-md-6">
        <div class="card card-block">
            <div class="title-block">
                <h3 class="title">Site Settings</h3>
            </div>

            <?php
            echo $this->Form->create($settings, ['id' => 'settinsg-form']);
            echo $this->Form->control('title');
            echo $this->Form->control('subtitle');
            echo $this->Form->button(__('Save Settings'));
            echo $this->Form->end();
            ?>

        </div>
    </div>
</div>

<?php $this->start('script'); ?>
<script>
    (function() {
        $("#settings-form").validate({
            rules: {
                title: {
                    required: true
                },
            }
        });
    })();
</script>
<?php $this->end(); ?>
