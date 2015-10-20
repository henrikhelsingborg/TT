<?php
    get_header();
?>

<div class="section-article">
    <div class="container">
        <div class="row">
            <div class="columns large-12">
                <?php the_breadcrumb(); ?>
            </div>
        </div>

        <div class="row">
            <?php get_template_part('templates/partials/sidebar', 'left'); ?>

            <div class="columns large-6 medium-8 mobile-menu-12 small-12 print-12 left">
                <?php get_template_part('templates/partials/article'); ?>

                <?php if (is_active_sidebar('content-area')) : ?>
                <div class="widget-area" id="widget-content-area">
                    <?php dynamic_sidebar("content-area"); ?>
                </div>
                <?php endif; ?>

                <?php get_template_part('templates/partials/article', 'share'); ?>
            </div>

            <?php
                if (is_active_sidebar('right-sidebar')) {
                    get_template_part('templates/partials/sidebar', 'right');
                }
            ?>
        </div>

        <?php if (is_active_sidebar('content-area-bottom')) : ?>
        <div class="row" id="widget-content-area-bottom">
            <?php dynamic_sidebar('content-area-bottom'); ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>