<?php
    get_header();

    $centerClasses = 'large-6 medium-6 small-12';
    if (!is_active_sidebar('right-sidebar')) {
        $centerClasses = 'large-9 medium-9 small-12';
    }
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

            <div class="columns <?php echo $centerClasses; ?>">
                <?php get_template_part('templates/partials/article'); ?>

                <?php if (is_active_sidebar('content-area')) : ?>
                <div class="widget-area" id="widget-content-area">
                    <?php dynamic_sidebar("content-area"); ?>
                </div>
                <?php endif; ?>
            </div>

            <?php if (is_active_sidebar('right-sidebar')) : ?>
            <aside class="columns large-3 medium-3 small-12">
                <?php dynamic_sidebar('right-sidebar'); ?>
            </aside>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>