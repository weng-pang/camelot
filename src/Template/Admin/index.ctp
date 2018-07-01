<?php
/**
 * @var \App\View\AppView $this
 * @var array[] $popularArticles
 * @var array[] $viewsOverTime
 */
?>
<div class="title-block">
    <div class="title">Popular articles</div>
    <div class="title-description">Top three most viewed articles on the website.</div>
</div>

<div class="row">
    <?php foreach ($popularArticles as $article): ?>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <div class="header-block">
                        <p class="title">
                            <?= h($article['title']) ?>
                        </p>
                        <p class="title-description">
                            Viewed <?= $this->Number->format($article['views']) ?> time<?= $article['views'] == 1 ? '' : 's' ?>
                        </p>
                    </div>
                </div>
                <div class="card-block">
                    <?= h($this->Text->truncate(strip_tags($article['body']), 50, ['exact' => false])) ?>
                </div>
                <div class="card-footer">
                    <?= $this->element('Admin/Buttons/view', ['url' => ['controller' => 'articles', 'action' => 'view', $article['slug']]]) ?>
                    <?= $this->element('Admin/Buttons/edit', ['url' => ['controller' => 'articles', 'action' => 'edit', $article['slug']]]) ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>

<div class="title-block">
    <div class="title">History</div>
    <div class="title-description">Number of article views over time.</div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <div class="header-block">
                    <p class="title">
                        All time
                    </p>
                    <p class="title-description">
                        All page views ever recorded
                    </p>
                </div>
            </div>
            <div class="card-block">
                <div id="chart" class="c3" style="width: 100%; height: 200px"></div>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
</div>

<?php $this->start('script') ?>
<?= $this->Html->css('lib/c3.min.css') ?>
<?= $this->Html->script('lib/d3.min.js') ?>
<?= $this->Html->script('lib/c3.min.js') ?>
<?php
$timeData = ['Time'];
$viewsData = ['Views'];
foreach($viewsOverTime as $views) {
    $timeData[] = $views['year'] . '-' . $views['month'] . '-' . $views['day'];
    $viewsData[] = $views['views'];
}
?>
<script>
    c3.generate({
        data: {
            x: 'Time',
            columns: [
                <?= json_encode($timeData) ?>,
                <?= json_encode($viewsData) ?>
            ]
        },
        axis: {
            x: {
                type: 'timeseries',
                tick: {
                    format: '%Y-%m-%d'
                }
            }
        }
    });
</script>
<?php $this->end() ?>
