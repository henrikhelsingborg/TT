<?php
    global $page;
    $image = false;
    if (has_post_thumbnail($page->ID)) {
        $image_id = get_post_thumbnail_id( $page->ID );
        $image = wp_get_attachment_image_src( $image_id, 'single-post-thumbnail' );
        $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
    }
?>
<div class="box box-outlined box-inline box-share">
    <h3>Dela artikeln</h3>
    <div class="box-content box-content-padding">
        <?php if ($image) : ?>
        <div class="share-image" style="background-image:url('<?php echo $image[0]; ?>');"></div>
        <?php endif; ?>
        <div class="share-content">
            <h5><?php the_title(); ?></h5>
            <span class="share-url">http://helsingborg.se/ewfwe</span>
            <ul class="share-icons">
                <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_the_permalink()); ?>"><i class="fa fa-facebook"></i></a></li>
                <li><a href="http://twitter.com/share?url=<?php echo urlencode(wp_get_shortlink()); ?>"><i class="fa fa-twitter"></i></a></li>
                <li><a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_the_permalink()); ?>&amp;title=<?php echo get_the_title(); ?>&amp;summary=<?php echo get_the_excerpt(); ?>&amp;source=Helsingborg.se"><i class="fa fa-linkedin"></i></a></li>
            </ul>
        </div>
    </div>
</div>