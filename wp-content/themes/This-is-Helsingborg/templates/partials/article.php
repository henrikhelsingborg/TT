<?php
    $the_content = get_extended($post->post_content);
    $main = $the_content['main'];
    $content = $the_content['extended'];
?>
<article class="article">
    <header class="article-header">
        <?php get_template_part('templates/partials/accessibility', 'article'); ?>
        <h1><?php the_title(); ?></h1>
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