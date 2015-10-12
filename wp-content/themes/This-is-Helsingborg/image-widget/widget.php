<?php echo $before_widget; ?>
    <?php if (in_array($args['id'], array('left-sidebar', 'left-sidebar-bottom', 'right-sidebar'))) get_template_part('templates/partials/stripe'); ?>
    <?php if (!empty($instance['link'])) : ?>
    <a href="<?php echo $instance['link']; ?>" target="<?php echo $instance['linktarget']; ?>">
    <?php endif; ?>
    <img src="<?php echo $instance['imageurl']; ?>" alt="<?php echo $instance['alt']; ?>" class="responsive" width="<?php echo $instance['width']; ?>" height="<?php echo $instance['height']; ?>">
    <?php if (!empty($instance['link'])) : ?>
    </a>
    <?php endif; ?>

    <?php if (strlen($title) > 0) : ?><h3 class="box-title"><?php echo $title; ?></h3><?php endif; ?>

    <?php if (!empty($description)) : ?>
    <div class="box-content padding-x1-5">
        <?php echo wpautop($description); ?>
    </div>
    <?php endif; ?>
<?php echo $after_widget; ?>