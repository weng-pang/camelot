<?php
/**
 * This element is responsible for displaying an <li> (list item) containing a link to somewhere in the website.
 * One of these for each menu item will be displayed in the main admin navigation menu. Note that this is recursive.
 * That means that a menu-item.ctp may include additional menu-item's below itself. This is used to group many similar
 * actions together under one parent menu item (e.g. "Add", "View", or "Analyse" orders).
 *
 * The following variables are passed to this template, by passing an array of options as the second
 * argument to: $this->element('Admin/menu-item', ...) from menu.ctp or this menu-item.ctp file:
 *
 * @var string $label
 * @var string $icon (optional)
 * @var string $controller
 * @var string $action
 * @var array $children (optional)
 */

/*
 * What page is the user currently viewing? We need to know this so that we can highlight the correct menu item,
 * to provide visual feedback to the user about where they are in the website.
 */
$currentController = $this->request->getParam('controller');

/*
 * Figure out if this menu-item belongs to the currently viewed page. Also, setup some little fragments of HTML so that
 * we can construct the final resulting HTML later on. I like the final "echo" statements to have zero business logic in
 * them if possible. Hence, all of the decisions about what HTML to display is essentially figured out here, before we
 * actually echo anything to the screen.
 */
$isActive = $controller === $currentController;
$activeClass = $isActive ? 'active' : '';
$expandedClass = isset($children) && !empty($children) && $isActive ? 'open' : '';
$icon = isset($icon) && $icon ? "<i class='fa fa-{$icon}'></i>" : '';

echo "<li class='{$activeClass} {$expandedClass}'>";

if (isset($children) && !empty($children)) {

    /*
     * If we are showing a menu item with children, then it needs to include a both an arrow, indicating to the
     * user that there is children, and also it has to contain the actual children menu-items within a sub-list.
     * The template I'm using here wants the sublist to be a <ul> (unordered list) with class "sidebar-nav".
     * Notice how for each child in this sub-list, we invoke this very same template again (Admin/menu-item.ctp).
     */
    $expandArrow = '<i class="fa arrow"></i>';

    echo $this->Html->link(
        $icon . $label . $expandArrow,
        ['controller' => $controller, 'action' => $action],
        ['escape' => false] // This is because the first argument to $this->Html->link() contains HTML code.
    );

    echo '<ul class="sidebar-nav">';

    foreach($children as $child) {
        echo $this->element('Admin/menu-item', $child);
    }

    echo '</ul>';

} else {

    /*
     * If there are no children, then we only need to display one item.
     */
    echo $this->Html->link(
        $icon . $label,
        ['controller' => $controller, 'action' => $action],
        ['escape' => false] // This is because the first argument to $this->Html->link() contains HTML code.
    );

}

echo '</li>';