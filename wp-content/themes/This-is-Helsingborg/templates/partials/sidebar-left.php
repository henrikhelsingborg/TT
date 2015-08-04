<aside class="sidebar-left columns large-3 medium-3 hide-for-small-only">
    <?php get_template_part('templates/partials/sidebar', 'search'); ?>

    <?php if (is_active_sidebar('left-sidebar')) : ?>
    <div class="row sidebar-left-widgets">
        <?php dynamic_sidebar('left-sidebar'); ?>
    </div>
    <?php endif; ?>

    <?php get_template_part('templates/partials/sidebar', 'navigation'); ?>

    <?php if (is_active_sidebar('left-sidebar')) : ?>
    <div class="row sidebar-left-widgets-bottom">
        <?php dynamic_sidebar('left-sidebar-bottom'); ?>
    </div>
    <?php endif; ?>
</aside>