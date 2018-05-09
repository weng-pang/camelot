<h1>Articles</h1>

<div>
    <?= $this->Html->link('Add Article', ['action' => 'add'], ['class' => 'btn btn-oval btn-primary']) ?>
</div>

<div class="card card-block">

    <table class="table">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('title') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th></th>
            </tr>
        </thead>

        <!-- Here is where we iterate through our $articles query object, printing out article info -->
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td style="width: 60%">
                        <?= $this->Html->link($article->title, ['action' => 'view', $article->slug]) ?>
                    </td>
                    <td>
                        <?= $article->created->timeAgoInWords() ?>
                    </td>
                    <td class="action-col">
                        <?= $this->Html->link(
                                '<i class="fa fa-edit"></i> Edit',
                                ['action' => 'edit', $article->slug],
                                ['class' => 'btn btn-oval btn-primary', 'escape' => false]
                            ) ?>
                        <?= $this->Form->postLink(
                            '<i class="fa fa-trash"></i> Delete',
                            ['action' => 'delete', $article->slug],
                            ['confirm' => 'Are you sure?', 'class' => 'btn btn-oval btn-delete btn-danger', 'escape' => false])
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>