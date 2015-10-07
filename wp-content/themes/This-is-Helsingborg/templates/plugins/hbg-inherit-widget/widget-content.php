<?php echo $before_widget; ?>
    <?php if (in_array($args['id'], array('left-sidebar', 'left-sidebar-bottom', 'right-sidebar'))) get_template_part('templates/partials/stripe'); ?>
    <h3 class="box-title"><?php echo $post->post_title; ?></h3>

    <div class="box-content padding-x2">
        <?php echo the_content(); ?>
    </div>
<?php echo $after_widget; ?>