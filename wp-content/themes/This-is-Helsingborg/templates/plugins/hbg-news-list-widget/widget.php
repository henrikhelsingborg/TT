<?php echo $before_widget; ?>
    <?php if (in_array($args['id'], array('left-sidebar', 'left-sidebar-bottom', 'right-sidebar'))) get_template_part('templates/partials/stripe'); ?>
    <div class="row">
    <ul class="list list-news">
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
        ?>

        <li class="large-12 columns">
            <a href="<?php echo $link; ?>" class="row">
                <?php
                    if (has_post_thumbnail( $page->ID ) ) :
                        $image_id = get_post_thumbnail_id( $page->ID );
                        $image = wp_get_attachment_image_src( $image_id, 'single-post-thumbnail' );
                        $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                ?>
                    <div class="large-4 medium-4 small-12 print-4 columns news-image">
                        <img src="<?php echo $image[0]; ?>" alt="<?php echo $alt_text; ?>">
                    </div>
                <?php endif; ?>

                <div class="large-8 medium-8 small-12 print-8 columns news-content">
                    <h2 class="news-title"><?php echo $page->post_title; ?></h2>
                    <span class="news-date"><?php echo date('Y-m-d \k\l\. H:i', strtotime($page->post_modified)); ?></span>
                    <p><?php echo wpautop($main, true); ?></p>
                    <span class="read-more link-item">Läs mer</span>
                </div>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    </div>
<?php echo $after_widget; ?>