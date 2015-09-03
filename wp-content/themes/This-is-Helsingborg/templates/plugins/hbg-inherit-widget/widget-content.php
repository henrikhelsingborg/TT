<?php
echo $before_widget;
if ($args['id'] == 'slider-area') :
?>

    <h3 class="widget-title"><?php echo $post->post_title; ?></h3>

    <div class="box-content box-content-padding-x2">
        <?php echo the_content(); ?>
    </div>

<?php else : ?>

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

<?php
endif;
echo $after_widget;
?>