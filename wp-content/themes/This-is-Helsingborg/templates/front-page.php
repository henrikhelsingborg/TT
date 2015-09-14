<?php
    /*
    Template Name: Start
    */

    get_header();
?>

<?php if (is_active_sidebar('slider-area')) : ?>
<section class="section-featured creamy">
    <div class="container">
        <div class="row">
            <?php dynamic_sidebar('slider-area'); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section-news">
    <div class="container">

        <div class="row">
            <div class="columns large-12">
                <h2 class="text-magenta no-margin-padding"><i class="fa fa-newspaper-o"></i> <?php echo (get_field('content_title')) ? get_field('content_title') : 'Aktuellt i Helsingborg'; ?></h2>
            </div>
        </div>

        <?php dynamic_sidebar('content-area'); ?>
    </div>
</section>

<?php get_footer(); ?>