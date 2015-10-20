<?php echo $before_widget; ?>
<div class="row">
    <div class="index" data-equalizer>
        <?php
            foreach ($items as $num => $item) :
                $item_id = $item_ids[$num];
                $page = get_page($item_id, OBJECT, 'display');
                if ($page->post_status !== 'publish') continue;

                $link = get_permalink($page->ID);

                $the_content = get_extended($page->post_content);
                $main = $the_content['main'];
                $content = $the_content['extended'];

                $image = false;
                if (has_post_thumbnail($page->ID)) {
                    $image_id = get_post_thumbnail_id( $page->ID );
                    $image = wp_get_attachment_image_src( $image_id, 'single-post-thumbnail' );
                    $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                }

                $title = $page->post_title;
                if (isset($instance['headline' . ($num+1)]) && strlen($instance['headline' . ($num+1)]) > 0) {
                    $title = $instance['headline' . ($num+1)];
                }
        ?>
        <div class="columns <?php if (is_front_page() && $args['id'] == 'content-area') : ?>large-4 medium-4<?php elseif ($args['id'] == 'content-area-bottom') : ?>large-3 medium-4 small-12<?php elseif (!is_page_template('templates/index-page.php')) : ?>large-6 medium-6 print-6<?php else : ?>large-4 medium-6 print-6<?php endif; ?> end">
            <a href="<?php echo $link; ?>" class="index-item" data-equalizer-watch>
                <?php if (isset($image[0]) && $instance['hide_image' . ($num+1)] != 1) : ?>
                <img src="<?php echo $image[0]; ?>" alt="<?php echo $title; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>">
                <?php endif; ?>
                <div class="index-container">
                    <div class="index-caption link-item"><?php echo $title; ?></div>
                    <div class="index-description"><?php echo wpautop($main, true); ?></div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php echo $after_widget; ?>