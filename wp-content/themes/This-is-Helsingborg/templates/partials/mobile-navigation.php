<?php
/**
 * Displays the main menu navigation as mobile menu
 */
/*
wp_nav_menu(array(
    'theme_location'  => 'main-menu',
    'container'       => 'nav',
    'container_class' => 'nav-mobilemenu',
    'items_wrap'      => '<ul class="nav">%3$s</ul>',
    'depth'           => 1
));
*/

require_once(get_template_directory() . '/library/helsingborg-walker-mobile.php');
    $walker_page = new Helsingborg_Walker_Mobile();
?>

<nav class="navbar-aside nav-mobilemenu">
    <ul class="nav nav-list">
        <?php
            $menu = wp_cache_get('menu_mobile_' . $post->ID);
            if ( false === $menu ) {
                $menu = wp_list_pages(array(
                    'title_li' => '',
                    'echo'     => 0,
                    'walker'   => $walker_page,
                    'include'  => get_included_pages($post)
                ));

                wp_cache_set('menu_mobile-' . $post->ID , $menu);
            }

            echo $menu;
        ?>
    </ul>
</nav>