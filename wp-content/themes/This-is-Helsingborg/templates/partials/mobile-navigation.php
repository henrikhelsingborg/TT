<?php
/**
 * Displays the main menu navigation as mobile menu
 */
wp_nav_menu(array(
    'theme_location'  => 'main-menu',
    'container'       => 'nav',
    'container_class' => 'nav-mobilemenu',
    'items_wrap'      => '<ul class="nav">%3$s</ul>',
    'depth'           => 1
));
?>