<aside class="right-off-canvas-menu" tabindex="-1">
    <?php
        $defaults = array(
            'theme_location'  => 'sidebar-menu',
            'container'       => '',
            'menu_class'      => 'menu',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'items_wrap'      => mobileMenuStaticItems(),
        );

        wp_nav_menu($defaults);
    ?>
</aside>


<a class="exit-off-canvas"></a>
