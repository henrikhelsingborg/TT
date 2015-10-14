<?php $today = date('Y-m-d'); ?>
<?php echo $before_widget; ?>
    <?php if (in_array($args['id'], array('left-sidebar', 'left-sidebar-bottom', 'right-sidebar'))) get_template_part('templates/partials/stripe'); ?>

    <h3 class="box-title">
        <?php echo $title; ?>
        <?php if ($show_rss == 'rss_yes') { echo('<a href="'.$rss_link.'" class="rss-link"><span class="icon"></span></a>'); } ?>
    </h3>
    <div class="box-content">
        <ul class="list list-links">
            <?php
            foreach ($items as $num => $item) :
                $item_id = $item_ids[$num];
                $page = get_post($item_id, OBJECT, 'display');

                // Continue if not published
                if ($page->post_status !== 'publish') continue;

                // Check if link should be opened in new window
                $target = $item_targets[$num] ? 'target="_blank"' : '';

                $class = '';
                if ($item_warnings[$num]) {
                    $class = 'alert-warning';
                } else if ($item_infos[$num]) {
                    $class = 'alert-info';
                }

                $title = $item;
                $link = $item_links[$num];

                // Backward compability
                if (!empty($item_id)) {
                    $datetime = strtotime($page->post_modified);
                } else if (!empty($item_dates[$num])){
                    $datetime = strtotime($item_dates[$num]);
                } else {
                    $datetime = '';
                }
            ?>
                <li class="<?php echo $class; ?>">
                    <a href="<?php echo $link; ?>" <?php echo $target; ?>>
                        <span class="link-item <?php if (strpos($args['id'], 'sidebar') > -1) : ?>link-item-light<?php endif; ?>"><?php echo $title; ?></span>
                        <?php
                            if ($show_dates && !empty($datetime)) :
                            $date = date_i18n('d M Y', $datetime);
                            if ($today == $date) :
                        ?>
                            <span class="date"><time datetime="<?php echo date('Y-m-d H:i', $datetime); ?>">Idag <?php echo $time; ?></time></span>
                        <?php else : ?>
                            <span class="date"><time datetime="<?php echo date('Y-m-d H:i', $datetime); ?>"><?php echo $date; ?></time></span>
                        <?php
                            endif;
                            endif;
                        ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php echo $after_widget; ?>