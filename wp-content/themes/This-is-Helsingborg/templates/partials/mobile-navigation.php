<?php
/**
 * Displays the main menu navigation as mobile menu
 */

require_once(get_template_directory() . '/lib/Walker/helsingborg-walker-mobile.php');
$walker_page = new HelsingborgWalkerMobile();
?>

<nav class="navbar-aside nav-mobilemenu">
    <ul class="nav nav-list">
        <?php
        $menu = get_transient('menu_mobile_' . $post->ID);
        if (!$menu || (isset($_GET['menu_cache']) && $_GET['menu_cache'] == 'false')) {
            $menu = wp_list_pages(array(
                'title_li' => '',
                'echo'     => 0,
                'walker'   => $walker_page,
                'include'  => get_included_pages($post)
            ));

            set_transient('menu_mobile_' . $post->ID, $menu, 60*60*168);
        }

        echo $menu;
        ?>
    </ul>
</nav>