<?php echo $before_widget; ?>
<div class="row">
    <div class="index" data-equalizer>
        <?php
            foreach ($items as $num => $item) :
                $item_id = $item_ids[$num];
                $page = get_page($item_id, OBJECT, 'display');
                if ($page->post_status !== 'publish') continue;

                // Get the content, see if <!--more--> is inserted
                $the_content = get_extended(strip_shortcodes($page->post_content));
                $main = $the_content['main'];
                $content = $the_content['extended']; // If content is empty, no <!--more--> tag was used -> content is in $main

                $link = get_permalink($page->ID);

                $image_id = get_post_thumbnail_id($page->ID);
                $image = wp_get_attachment_image_src($image_id, 'single-post-thumbnail');
                $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        ?>
        <div class="columns <?php if (is_front_page()) : ?>large-4 print-4<?php else : ?>large-6 print-6<?php endif; ?> medium-6 end">
            <a href="<?php echo $link; ?>" class="index-item index-item-filled" data-equalizer-watch>
                <?php if (isset($image[0])) : ?>
                <img src="<?php echo $image[0]; ?>" alt="<?php echo $page->post_title; ?>" width="<?php echo $image[1]; ?>" height="<?php echo $image[2]; ?>">
                <?php endif; ?>
                <div class="index-container">
                    <div class="index-caption link-item link-item-light"><?php echo $page->post_title ?></div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php echo $after_widget; ?>