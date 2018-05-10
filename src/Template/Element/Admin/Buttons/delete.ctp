<?php
/**
 * @var \App\View\AppView $this
 * @var array $url
 */

echo $this->Form->postLink(
    '<i class="fa fa-trash"></i> Delete',
    $url,
    [
        'class' => 'btn btn-oval btn-danger btn-delete',
        'escape' => false,
        'confirm' => 'Are you sure?'
    ]
);