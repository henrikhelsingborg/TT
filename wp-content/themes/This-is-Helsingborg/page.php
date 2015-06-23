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
            <aside class="columns large-3 medium-3 hide-for-small-only">
                <?php get_template_part('templates/partials/sidebar', 'navigation'); ?>
            </aside>

            <div class="columns <?php echo $centerClasses; ?>">
                <?php
                    $the_content = get_extended($post->post_content);
                    $main = $the_content['main'];
                    $content = $the_content['extended'];
                ?>
                <article class="article">
                    <header class="article-header">
                        <h1><?php the_title(); ?></h1>
                    </header>

                    <?php if (!empty($content)) : ?>
                    <div class="ingress">
                        <?php echo apply_filters('the_content', $main); ?>
                    </div>
                    <?php endif; ?>

                    <div class="article-body">
                    <?php
                        if (!empty($content)) {
                            echo apply_filters('the_content', $content);
                        } else {
                            echo apply_filters('the_content', $main);
                        }
                    ?>
                    </div>
                </article>

                <?php if (is_active_sidebar('content-area')) : ?>
                <div class="widget-area" id="widget-content-area">
                    <?php dynamic_sidebar("content-area"); ?>
                </div>
                <?php endif; ?>
            </div>

            <?php if (is_active_sidebar('right-sidebar')) : ?>
            <aside class="columns large-3 medium-3 small-12">
                Sidebar widgets
            </aside>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>