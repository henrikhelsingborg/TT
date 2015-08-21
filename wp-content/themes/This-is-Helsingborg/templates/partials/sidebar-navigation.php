<?php
    /* Generates the page tree, skips drafted pages */
    require_once(get_template_directory() . '/lib/Walker/helsingborg-walker.php');
    $walker_page = new Helsingborg_Walker();
?>
<nav class="navbar-aside">
    <ul class="nav nav-list">
        <?php
            $menu = wp_cache_get('menu_' . $post->ID);
            if ( false === $menu ) {
                $menu = wp_list_pages(array(
                    'title_li' => '',
                    'echo'     => 0,
                    'walker'   => $walker_page,
                    'include'  => get_included_pages($post)
                ));

                wp_cache_set('menu_' . $post->ID , $menu);
            }

            echo $menu;
        ?>
    </ul>
</nav>
