<style>
article {
    max-width: 750px;
    width: 100%;
}
article ul {
    list-style-type: disc;
    margin-left: 20px;
}
</style>

<?php
    $content = get_extended($post->post_content);
?>

<div class="wrap">
    <h2><?php the_title(); ?></h2>
    <article>
        <?php echo apply_filters('the_content', $content['main']); ?>
        <?php echo apply_filters('the_content', $content['extended']); ?>
    </article>
</div>