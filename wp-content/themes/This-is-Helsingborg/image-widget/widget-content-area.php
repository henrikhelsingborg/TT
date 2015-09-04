<?php
    if (!defined('ABSPATH')) die('-1');

    echo $before_widget;

    preg_match_all('#<a([^>])+>(.*?)</a>#i', $instance['description'], $matches);
    $description = $instance['description'];

    if (isset($matches[2][0])) {
        $description = $matches[2][0];
    }

?>
<div class="box box-outlined">
    <?php echo (!empty($title)) ? '<h3>' . $title . '</h3>' : ''; ?>
    <div class="box-content">
        <?php if (!empty($instance['link'])) : ?>
        <a href="<?php echo $instance['link']; ?>" target="<?php echo $instance['linktarget']; ?>">
        <?php endif; ?>

            <img src="<?php echo $instance['imageurl']; ?>" alt="<?php echo $instance['alt']; ?>" class="responsive">

            <?php if (!empty($description)) : ?>
            <div class="box-content-padding">
                <div class="<?php echo $this->widget_options['classname']; ?>-description">
                    <?php echo wpautop($description); ?>
                </div>
            </div>
            <?php endif; ?>

        <?php if (!empty($instance['link'])) : ?>
        </a>
        <?php endif; ?>
    </div>
</div>
<?php echo $after_widget; ?>