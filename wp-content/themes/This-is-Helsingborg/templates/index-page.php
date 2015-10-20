<?php
/*
Template Name: Fullbredd med meny
*/
    get_header();
?>

<section class="section-article">
    <div class="container">
        <div class="row">
            <div class="columns large-12">
                <?php the_breadcrumb(); ?>
            </div>
        </div>

        <div class="row">
            <?php get_template_part('templates/partials/sidebar', 'left'); ?>

            <div class="columns large-9 medium-9 small-12 left">
                <?php get_template_part('templates/partials/article'); ?>

                <?php if (is_active_sidebar('content-area')) : ?>
                <div class="widget-area" id="widget-content-area">
                    <?php dynamic_sidebar('content-area'); ?>
                </div>
                <?php endif; ?>

                <?php get_template_part('templates/partials/article', 'share'); ?>
            </div>
        </div>

        <?php if (is_active_sidebar('content-area-bottom')) : ?>
        <div class="row" id="widget-content-area-bottom">
            <?php dynamic_sidebar('content-area-bottom'); ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>