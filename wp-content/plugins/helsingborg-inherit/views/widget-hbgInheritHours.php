<?php echo $before_widget; ?>
<h2><?php echo (isset($instance['title']) && strlen($instance['title']) > 0) ? $instance['title'] : $post->title; ?></h2>
<div class="divider">
    <div class="upper-divider"></div>
    <div class="lower-divider"></div>
</div>
<div class="textwidget">
    <table>
        <tbody>
            <tr>
                <td>Måndag</td>
                <td><?php the_field('monday-open', $instance['post_id']); ?> - <?php the_field('monday-close', $instance['post_id']); ?></td>
            </tr>
            <tr>
                <td>Tisdag</td>
                <td><?php the_field('tuesday-open', $instance['post_id']); ?> - <?php the_field('tuesday-close', $instance['post_id']); ?></td>
            </tr>
            <tr>
                <td>Onsdag</td>
                <td><?php the_field('wednesday-open', $instance['post_id']); ?> - <?php the_field('wednesday-close', $instance['post_id']); ?></td>
            </tr>
            <tr>
                <td>Torsdag</td>
                <td><?php the_field('thursday-open', $instance['post_id']); ?> - <?php the_field('thursday-close', $instance['post_id']); ?></td>
            </tr>
            <tr>
                <td>Fredag</td>
                <td><?php the_field('friday-open', $instance['post_id']); ?> - <?php the_field('friday-close', $instance['post_id']); ?></td>
            </tr>
            <tr>
                <td>Lördag</td>
                <td><?php the_field('saturday-open', $instance['post_id']); ?> - <?php the_field('saturday-close', $instance['post_id']); ?></td>
            </tr>
            <tr>
                <td>Söndag</td>
                <td><?php the_field('sunday-open', $instance['post_id']); ?> - <?php the_field('sunday-close', $instance['post_id']); ?></td>
            </tr>
        </tbody>
    </table>

    <?php if (is_array(get_field('abnormal-opening-hours', $instance['post_id']))) : ?>
    <h4>Avvikande öppettider</h4>
    <table>
        <tbody>
            <?php foreach (get_field('abnormal-opening-hours', $instance['post_id']) as $date) : ?>
            <tr>
                <td><?php echo $date['date']; ?></td>
                <td>
                    <?php if ($date['open'] != '') : ?>
                        <?php echo $date['open']; ?> - <?php echo $date['close']; ?>
                    <?php else : ?>
                        Stängt
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <article>
        <?php echo the_content(); ?>
    </article>
</div>
<?php echo $after_widget; ?>