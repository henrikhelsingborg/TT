<section class="guide-section">
    <h2 class="section-title"><?php echo $post->post_title; ?></h2>

    <div class="row">
        <div class="columns large-12">
            <ul class="guide-list">
            
            <?php if (count($article_steps_meta["guide_step"])) : ?>
            <?php for ($i = 0; $i < count($article_steps_meta["guide_step"]); $i++) : ?>
                <li class="box <?php if ($i == 0) : ?>current<?php endif; ?>">
                    <?php
                        if (isset($article_steps_meta["guide_step_image"][$i])) :
                        $kk = wp_get_attachment_image_src( $article_steps_meta["guide_step_image"][$i], 'full', true)
                    ?>
                        <img src="<?php echo $kk[0]; ?>">
                    <?php endif; ?>

                    <h3 class="title"><?php echo $article_steps_meta["guide_step"][$i]; ?></h3>

                    <div class="box-content padding-x2 description">
                        <?php echo wpautop($article_steps_meta["guide_step_title"][$i], true); ?>
                        <?php if (strlen($article_steps_meta["guide_note"][$i]) > 0) : ?>
                            <p class="notes"><?php echo $article_steps_meta["guide_note"][$i]; ?></p>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endfor; ?>
            <?php endif; ?>

            </ul>
        </div>
    </div>

    <div class="row">
        <div class="columns large-12">
            <ul class="pagination" arial-label="pagination" role="menubar">
                <li><a href="#" class="button radius prev-step">&laquo; <?php echo __('Föregående'); ?></a></li>
                <?php for($i=0;$i<count($article_steps_meta["guide_step"]);$i++) : ?>
                <li <?php echo ($i==0) ? ' class="current-pager"' : ''; ?>><a href="#"><?php echo ($i+1); ?></a></li>
                <?php endfor; ?>
                <li><a href="#" class="button radius next-step"><?php echo __('Nästa'); ?> &raquo;</a></li>
            </ul>
        </div>
    </div>

</section>