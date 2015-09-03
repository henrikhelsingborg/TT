<?php echo $before_widget; ?>

    <div class="widget-content-holder">
        <h3 class="widget-title"><?php echo $post->post_title; ?></h3>
        <?php echo the_content(); ?>
    </div>

<?php echo $after_widget; ?>