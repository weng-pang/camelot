<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->assign('heading-class', 'post-heading');
$this->assign('heading', $user->name);
$this->assign('meta', "All articles by {$user->name}");

foreach($user->articles as $article) {
    echo $this->element('article-snippet', ['article' => $article]);
}
