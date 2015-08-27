<?php echo $before_widget; ?>
<div class="widget-content">
    <div class="widget-content-holder">
        <h2><?php echo $post->post_title; ?></h2>
        <div class="divider">
            <div class="upper-divider"></div>
            <div class="lower-divider"></div>
        </div>
        <div class="textwidget">
            <?php echo the_content(); ?>
        </div>
    </div>
</div>
<?php echo $after_widget; ?>