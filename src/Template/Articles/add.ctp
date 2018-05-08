<h1>Add Article</h1>
<?php
echo $this->Form->create($article, ['id' => 'article-form']);
echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]); // Hard code the user for now.
echo $this->Form->control('title');
echo $this->Form->control('body', ['rows' => '3']);
echo $this->Form->control('tag_string', ['type' => 'text']);
echo $this->Form->button(__('Save Article'));
echo $this->Form->end();
?>

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

