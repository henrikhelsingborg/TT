<?php echo $before_widget; ?>

    <h3 class="widget-title"><?php echo $post->post_title; ?></h3>

    <div class="box-content box-content-padding-x2">
        <?php echo the_content(); ?>
    </div>

<?php echo $after_widget; ?>