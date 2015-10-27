<?php echo $before_widget; ?>
<h2><?php echo (isset($instance['title']) && strlen($instance['title']) > 0) ? $instance['title'] : $post->title; ?></h2>
<div class="divider">
    <div class="upper-divider"></div>
    <div class="lower-divider"></div>
</div>
<div class="textwidget">
    <?php echo the_content(); ?>
</div>
<?php echo $after_widget; ?>