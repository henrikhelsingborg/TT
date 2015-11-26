<?php echo $before_widget; ?>
    <?php if (in_array($args['id'], array('left-sidebar', 'left-sidebar-bottom', 'right-sidebar'))) get_template_part('templates/partials/stripe'); ?>
    <h3 class="box-title"><?php echo (isset($instance['title']) && strlen($instance['title']) > 0) ? $instance['title'] : $post->title; ?></h3>

    <div class="box-content padding-x1-5">
        <?php echo the_content(); ?>
    </div>
<?php echo $after_widget; ?>