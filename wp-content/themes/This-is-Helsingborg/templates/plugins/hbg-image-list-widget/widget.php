<?php echo $before_widget; ?>
    <?php if (in_array($args['id'], array('left-sidebar', 'left-sidebar-bottom', 'right-sidebar'))) get_template_part('templates/partials/stripe'); ?>
    <?php if (isset($instance['title']) && strlen($instance['title']) > 0) : ?>
    <h3 class="box-title"><?php echo (($instance['title']) ? $instance['title'] : 'Bildspel'); ?></h3>
    <?php endif; ?>
    <div class="box-content <?php if ((!isset($instance['title']) || strlen($instance['title']) == 0) && $args['id'] == 'content-area') : ?>box-content-no-title-margin<?php endif; ?>">
        <ul class="orbit-slider" <?php if (count($items) > 1) : ?>data-orbit<?php endif; ?>>
            <?php
                foreach ($items as $num => $item) :
                    $force_width  = (!empty($item_force_widths[$num])) ? 'width:100%;' : '';
                    $force_margin = (!empty($item_force_margins[$num]) && !empty($item_force_margin_values[$num])) ? ' margin-top:-' . $item_force_margin_values[$num] . 'px;' : '';
            ?>
            <li>
                <img src="<?php echo $item_imageurl[$num]; ?>" alt="<?php echo (isset($item_alts[$num]) && strlen($item_alts[$num]) > 0) ? $item_alts[$num] : 'Bildspel'; ?>">
                <?php if (!empty($item_texts[$num])) : ?>
                <div class="caption">
                    <div class="caption-content">
                        <div class="row">
                            <div class="columns large-12">
                                <?php
                                    if (!empty($item_texts[$num])) {
                                        echo $item_texts[$num];
                                    }

                                    if (!empty($item_links[$num])) :
                                ?>
                                    <a href="<?php echo $item_links[$num]; ?>" class="read-more">Läs mer</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php echo $after_widget; ?>