<?php get_header(); ?>

<section class="section-article">
    <div class="container">
        <div class="row">
            <div class="columns large-12">
                <?php the_breadcrumb(); ?>
            </div>
        </div>
        <div class="row">
            <div class="columns large-3 medium-3 hide-for-small-only">
                <?php get_template_part('templates/partials/sidebar', 'navigation'); ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>