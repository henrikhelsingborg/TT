<?php echo $before_widget; ?>
<div class="collection collection-test-colors" data-equalizer>
    <div class="row">
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

                $columns = 6;
                switch ($instance['columns']) {
                    case 2:
                        $columns = 6;
                        break;

                    case 3:
                        $columns = 4;
                        break;

                    default:
                        $columns = 6;
                        break;
                }
        ?>
        <a data-equalizer-watch href="<?php echo $link ?>" class="collection-item columns large-<?php echo $columns; ?> medium-<?php echo $columns; ?> small-12 left" data-columns="<?php echo $columns; ?>">
            <div class="collection-item-content">
                <div class="collection-item-image" style="background-image:url('<?php echo $image[0]; ?>');"></div>
                <div class="collection-item-headline">
                    <?php echo $title; ?>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php echo $after_widget; ?>
