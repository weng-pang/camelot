<?php
/**
 * Notice how this particular class doesn't include ANY HTML AT ALL. This is because we already have:
 *  - The ability to output an article title with the first few characters of the body
 *  - The ability to display a header and a subheading.
 *
 * As a result, the view not only is much easier to maintain (compared to if we had of copied the relevant HTML into
 * here again), but it consistent with the rest of the website (because the rest of the website also uses these same
 * approaches where possible). One change in the 'article-snippet' template will result in the template being updated
 * all across the entire site with only a single change to the template. Equally, we don't need to concern ourselves
 * with how the heading is actually displayed. By using $this->assign(), we are leaving it up to the layout to decide
 * how to display the heading. We need only concern ourselves with the content inside the headings, not its style.
 *
 * These comments here are not required. However they do make editing the template ni an IDE simpler. They are
 * providing a hint to the IDE as to what variables we think we've passed to the template from
 * our Controller (this $user variable), and what type of object CakePHP provides when we reference "$this".
 * 
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->assign('heading-class', 'post-heading');
$this->assign('heading', $user->name);
$this->assign('meta', "All articles by {$user->name}");

foreach($user->articles as $article) {
    echo $this->element('article-snippet', ['article' => $article]);
}
