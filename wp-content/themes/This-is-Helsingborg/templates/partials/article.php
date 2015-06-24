<?php
    $the_content = get_extended($post->post_content);
    $main = $the_content['main'];
    $content = $the_content['extended'];
?>
<article class="article">
    <header class="article-header">
        <div class="row">
            <div class="columns large-12">
                <?php get_template_part('templates/partials/accessibility', 'article'); ?>
                <h1><?php the_title(); ?></h1>
            </div>
        </div>

        <?php if (is_active_sidebar('slider-area')) : ?>
        <div class="row">
            <?php dynamic_sidebar('slider-area'); ?>
        </div>
        <?php endif; ?>
    </header>

    <?php if (!empty($main)) : ?>
    <div class="article-ingress">
        <?php echo apply_filters('the_content', $main); ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($content)) : ?>
    <div class="article-body">
    <?php
        if (!empty($content)) {
            echo apply_filters('the_content', $content);
        } else {
            echo apply_filters('the_content', $main);
        }
    ?>
    </div>
    <?php endif; ?>
</article>