<?php echo $before_widget; ?>
    <?php if (in_array($args['id'], array('left-sidebar', 'left-sidebar-bottom', 'right-sidebar'))) get_template_part('templates/partials/stripe'); ?>
    <h3 class="box-title"><?php echo (isset($instance['title']) && strlen($instance['title']) > 0) ? $instance['title'] : $post->title; ?></h3>

    <div class="box-content padding-x1-5">
        <table class="table table-opening-hours" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td>Måndag</td>
                    <td>
                        <time itemprop="openingHours" datetime="Mo <?php the_field('monday-open', $instance['post_id']); ?>-<?php the_field('monday-close', $instance['post_id']); ?>">
                            <?php the_field('monday-open', $instance['post_id']); ?> - <?php the_field('monday-close', $instance['post_id']); ?>
                        </time>
                    </td>
                </tr>
                <tr>
                    <td>Tisdag</td>
                    <td>
                        <time itemprop="openingHours" datetime="Mo <?php the_field('tuesday-open', $instance['post_id']); ?>-<?php the_field('tuesday-close', $instance['post_id']); ?>">
                            <?php the_field('tuesday-open', $instance['post_id']); ?> - <?php the_field('tuesday-close', $instance['post_id']); ?>
                        </time>
                    </td>
                </tr>
                <tr>
                    <td>Onsdag</td>
                    <td>
                        <time itemprop="openingHours" datetime="Mo <?php the_field('wednesday-open', $instance['post_id']); ?>-<?php the_field('wednesday-close', $instance['post_id']); ?>">
                            <?php the_field('wednesday-open', $instance['post_id']); ?> - <?php the_field('wednesday-close', $instance['post_id']); ?>
                        </time>
                    </td>
                </tr>
                <tr>
                    <td>Torsdag</td>
                    <td>
                        <time itemprop="openingHours" datetime="Mo <?php the_field('thursday-open', $instance['post_id']); ?>-<?php the_field('thursday-close', $instance['post_id']); ?>">
                            <?php the_field('thursday-open', $instance['post_id']); ?> - <?php the_field('thursday-close', $instance['post_id']); ?>
                        </time>
                    </td>
                </tr>
                <tr>
                    <td>Fredag</td>
                    <td>
                        <time itemprop="openingHours" datetime="Mo <?php the_field('friday-open', $instance['post_id']); ?>-<?php the_field('friday-close', $instance['post_id']); ?>">
                            <?php the_field('friday-open', $instance['post_id']); ?> - <?php the_field('friday-close', $instance['post_id']); ?>
                        </time>
                    </td>
                </tr>
                <tr>
                    <td>Lördag</td>
                    <td>
                        <time itemprop="openingHours" datetime="Mo <?php the_field('saturday-open', $instance['post_id']); ?>-<?php the_field('saturday-close', $instance['post_id']); ?>">
                            <?php the_field('saturday-open', $instance['post_id']); ?> - <?php the_field('saturday-close', $instance['post_id']); ?>
                        </time>
                    </td>
                </tr>
                <tr>
                    <td>Söndag</td>
                    <td>
                        <time itemprop="openingHours" datetime="Mo <?php the_field('sunday-open', $instance['post_id']); ?>-<?php the_field('sunday-close', $instance['post_id']); ?>">
                            <?php the_field('sunday-open', $instance['post_id']); ?> - <?php the_field('sunday-close', $instance['post_id']); ?>
                        </time>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php if (strlen(get_the_content()) > 0) : ?>
        <article>
            <?php echo the_content(); ?>
        </article>
        <?php endif; ?>

        <?php if (is_array(get_field('abnormal-opening-hours', $instance['post_id']))) : ?>
        <h3 style="margin-top:15px;">Avvikande öppettider</h3>
        <table class="table table-opening-hours" cellpadding="0" cellspacing="0">
            <tbody>
                <?php foreach (get_field('abnormal-opening-hours', $instance['post_id']) as $date) : ?>
                <tr itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification">
                    <td>
                        <span itemprop="validFrom" content="<?php echo $date['date']; ?>"><?php echo $this->checkHoliday($date['date']); ?></span>
                        <span itemprop="validThrough" content="<?php echo $date['date']; ?>"></span>
                    </td>
                    <td>
                        <?php if ($date['open'] != '') : ?>
                            <time itemprop="opens" content="<?php echo $date['open']; ?>"><?php echo $date['open']; ?></time>
                            -
                            <time itemprop="closes" content="<?php echo $date['close']; ?>"><?php echo $date['close']; ?></time>
                        <?php else : ?>
                            Stängt
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
<?php echo $after_widget; ?>