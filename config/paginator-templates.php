<?php
return [
    'prevDisabled' => '',
    'nextDisabled' => '',
    // Because we are sorting in reverse-chronological order, the "Previous" page is actually the newer page and vice-verca
    'prevActive' => '<a class="btn btn-primary float-left" href="{{url}}">&larr; Newer</a>',
    'nextActive' => '<a class="btn btn-primary float-right" href="{{url}}">Older &rarr;</a>',
];