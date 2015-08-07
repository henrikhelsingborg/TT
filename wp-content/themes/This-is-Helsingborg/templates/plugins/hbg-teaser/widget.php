<?php echo $before_widget; ?>
<div class="teaser">
    <i class="fa <?php echo $instance['icon']; ?>"></i>
    <h3><?php echo $instance['title']; ?></h3>
    <p><?php echo $instance['text']; ?></p>
    <a href="<?php echo $instance['link-url']; ?>" class="btn btn-plain"><?php echo $instance['link-text']; ?></a>
</div>
<?php echo $after_widget; ?>