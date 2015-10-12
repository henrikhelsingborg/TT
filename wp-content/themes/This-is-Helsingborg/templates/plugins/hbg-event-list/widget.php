<?php
    $featured = false;
    $featuredImage = false;
    if (isset($instance['post_id']) && $instance['post_id'] > 0) {
        $featured = get_page($instance['post_id']);

        $image_id = get_post_thumbnail_id($featured->ID);
        $featuredImage = wp_get_attachment_image_src($image_id, 'single-post-thumbnail');
    }
?>

<?php echo $before_widget; ?>
    <?php if (in_array($args['id'], array('left-sidebar', 'left-sidebar-bottom', 'right-sidebar'))) get_template_part('templates/partials/stripe'); ?>
    
    <h3 class="box-title"><?php echo $title; ?></h3>
    <div class="box-content" id="widget-<?php echo $args['widget_id']; ?>" data-event-list="{'defaultImagePath':'<?php echo get_template_directory_uri(); ?>/assets/images/event-placeholder.jpg', 'administrationIds': '<?php echo $administration_ids; ?>', 'ammount': '<?php echo $amount; ?>'}">
        <ul class="event-list list list-events">

            <?php
                if ($featured) :
                    $the_content = get_extended($featured->post_content);
                    $main = $the_content['main'];
                    $content = $the_content['extended'];
            ?>
            <li class="event-item-featured">
                <a href="<?php echo get_permalink($featured->ID); ?>" class="event-item featured">
                    <?php if ($featuredImage) : ?>
                    <div class="columns large-4 medium-4 small-12 featured-image">
                        <img src="<?php echo $featuredImage[0]; ?>" class="responsive" alt="<?php echo $featured->post_title; ?>" width="<?php echo $featuredImage[1]; ?>" height="<?php echo $featuredImage[2]; ?>">
                    </div>
                    <?php endif; ?>
                    <div class="columns <?php if ($featuredImage) : ?>large-8 medium-8 small-12<?php else : ?>large-12 medium-12 small-12<?php endif; ?>">
                        <h3><?php echo $featured->post_title; ?></h3>
                        <p class="lead"><?php echo $main; ?></p>
                        <span class="link-item"><?php echo $instance['link-text']; ?></span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <?php endif; ?>

            <li class="event-loading"><i class="hbg-loading">Läser in evenemang</i></li>
            <li><a href="<?php echo $reference; ?>" class="list-more"><?php echo $link_text; ?></a></li>
        </ul>

        <?php
            /**
             * Get the modal window markup
             */
            get_template_part('templates/partials/modal', 'event');
        ?>
    </div>
<?php echo $after_widget; ?>