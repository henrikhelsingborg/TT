<?php
echo $before_widget;

if ($args['id'] == 'fun-facts-area') :
?>
<div class="fun-fact">
    <div class="fun-fact-title">
        <i class="fa <?php echo $instance['icon']; ?>"></i> <?php echo $instance['title']; ?>
    </div>
    <div class="fun-fact-caption"><?php echo $instance['text']; ?></div>
</div>
<?php else : ?>
<div class="teaser">
    <i class="fa <?php echo $instance['icon']; ?>"></i>
    <h3><?php echo $instance['title']; ?></h3>
    <p><?php echo $instance['text']; ?></p>
    <a href="<?php echo $instance['link-url']; ?>" class="btn btn-plain"><?php echo $instance['link-text']; ?></a>
</div>
<?php
endif;

echo $after_widget;
?>