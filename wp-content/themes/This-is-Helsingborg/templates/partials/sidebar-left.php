<aside class="sidebar-left columns large-3 medium-4 hide-for-mobile-menu-only hide-for-small-only">
    <?php if (is_active_sidebar('left-sidebar')) : ?>
    <div class="row sidebar-left-widgets">
        <?php dynamic_sidebar('left-sidebar'); ?>
    </div>
    <?php endif; ?>

    <?php get_template_part('templates/partials/sidebar', 'navigation'); ?>

    <?php if (is_active_sidebar('left-sidebar-bottom')) : ?>
    <div class="row sidebar-left-widgets-bottom">
        <?php dynamic_sidebar('left-sidebar-bottom'); ?>
    </div>
    <?php endif; ?>
</aside>