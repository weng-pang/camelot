<?php
/**
 * @var \App\View\AppView $this
 * @var array $url
 */

echo $this->Html->link(
    '<i class="fa fa-eye"></i> View',
    $url,
    ['class' => 'btn btn-oval btn-secondary btn-view', 'escape' => false]
);