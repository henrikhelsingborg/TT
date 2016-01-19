<?php
$data = get_fields($instance['post_id']);
echo $before_widget;
?>
    <?php if (in_array($args['id'], array('left-sidebar', 'left-sidebar-bottom', 'right-sidebar'))) get_template_part('templates/partials/stripe'); ?>
    <h2><?php echo (isset($instance['title']) && strlen($instance['title']) > 0) ? $instance['title'] : $post->title; ?></h2>

    <div class="box-content padding-x1-5">
        <table class="table table-opening-hours" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td>Måndag</td>
                    <td>
                        <?php if ($data['monday-open'] != '') : ?>
                        <time itemprop="openingHours" datetime="Mo <?php echo $data['monday-open']; ?> - <?php echo $data['monday-close']; ?>">
                            <?php echo $data['monday-open']; ?> - <?php echo $data['monday-close']; ?>
                        </time>
                        <?php else : ?>
                            Stängt
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Tisdag</td>
                    <td>
                        <?php if ($data['tuesday-open'] != '') : ?>
                        <time itemprop="openingHours" datetime="Mo <?php echo $data['tuesday-open']; ?> - <?php echo $data['tuesday-close']; ?>">
                            <?php echo $data['tuesday-open']; ?> - <?php echo $data['tuesday-close']; ?>
                        </time>
                        <?php else : ?>
                            Stängt
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Onsdag</td>
                    <td>
                        <?php if ($data['wednesday-open'] != '') : ?>
                        <time itemprop="openingHours" datetime="Mo <?php echo $data['wednesday-open']; ?> - <?php echo $data['wednesday-close']; ?>">
                            <?php echo $data['wednesday-open']; ?> - <?php echo $data['wednesday-close']; ?>
                        </time>
                        <?php else : ?>
                            Stängt
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Torsdag</td>
                    <td>
                        <?php if ($data['thursday-open'] != '') : ?>
                        <time itemprop="openingHours" datetime="Mo <?php echo $data['thursday-open']; ?> - <?php echo $data['thursday-close']; ?>">
                           <?php echo $data['thursday-open']; ?> - <?php echo $data['thursday-close']; ?>
                        </time>
                        <?php else : ?>
                            Stängt
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Fredag</td>
                    <td>
                        <?php if ($data['friday-open'] != '') : ?>
                        <time itemprop="openingHours" datetime="Mo <?php echo $data['friday-open']; ?> - <?php echo $data['friday-close']; ?>">
                            <?php echo $data['friday-open']; ?> - <?php echo $data['friday-close']; ?>
                        </time>
                        <?php else : ?>
                            Stängt
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Lördag</td>
                    <td>
                        <?php if ($data['saturday-open'] != '') : ?>
                        <time itemprop="openingHours" datetime="Mo <?php echo $data['saturday-open']; ?> - <?php echo $data['saturday-close']; ?>">
                            <?php echo $data['saturday-open']; ?> - <?php echo $data['saturday-close']; ?>
                        </time>
                        <?php else : ?>
                            Stängt
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Söndag</td>
                    <td>
                        <?php if ($data['sunday-open'] != '') : ?>
                        <time itemprop="openingHours" datetime="Mo <?php echo $data['sunday-open']; ?> - <?php echo $data['sunday-close']; ?>">
                            <?php echo $data['sunday-open']; ?> - <?php echo $data['sunday-close']; ?>
                        </time>
                        <?php else : ?>
                            Stängt
                        <?php endif; ?>
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
                <?php foreach ($data['abnormal-opening-hours'] as $date) : ?>
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