<?php
    global $page;
    $image = false;
    if (has_post_thumbnail($page->ID)) {
        $image_id = get_post_thumbnail_id( $page->ID );
        $image = wp_get_attachment_image_src( $image_id, 'single-post-thumbnail' );
        $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
    }
?>
<div class="box box-creamy box-share">
    <div class="box-content">
        <?php if ($image) : ?>
        <div class="share-image" style="background-image:url('<?php echo $image[0]; ?>');"></div>
        <?php endif; ?>
        <div class="share-content">
            <h5><span>Dela sidan:</span> <?php the_title(); ?></h5>
            <span class="share-url"><?php echo wp_get_shortlink(); ?></span>
            <ul class="share-icons">
                <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_the_permalink()); ?>" title="Dela på Facebook"><i class="fa fa-facebook"></i></a></li>
                <li><a href="http://twitter.com/share?url=<?php echo urlencode(wp_get_shortlink()); ?>" title="Dela på Twitter"><i class="fa fa-twitter"></i></a></li>
                <li><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_the_permalink()); ?>&amp;title=<?php echo get_the_title(); ?>&amp;summary=<?php echo get_the_excerpt(); ?>&amp;source=Helsingborg.se" title="Dela på LinkedIn"><i class="fa fa-linkedin"></i></a></li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>