<style>
#internblogg {
    margin: -12px;
}

#internblogg p {
    margin: 0;
}

#internblogg p {
    margin-top: 10px;
}

#internblogg li {
    padding: 15px 20px;
    margin: 0;
}

#internblogg li + li {
    border-top: 1px solid #EEEEEE;
}

#internblogg .sticky {
    border-top: 1px solid #43abce !important;
}

#internblogg .sticky + li {
    border-top: 1px solid #43abce !important;
}

#internblogg h3 {
    margin: 0;
    padding: 0;
}

#internblogg .readmore {
    display: block;
}

#internblogg p + .readmore {
    display: block;
    margin-top: 10px;
}

#internblogg .sticky {
    background: #d5eef7;
}
</style>

<div class="rss-widget">
    <ul id="internblogg">
        <?php
        $index = 0;
        if ($sticky->have_posts()) : while ($sticky->have_posts()) : $index++; $sticky->the_post(); ?>
            <li class="sticky">
                <a class="rsswidget" href="<?php echo admin_url() ?>/?page=helsingborgAdminBlogRead&amp;id=<?php the_ID(); ?>"><?php the_title(); ?></a>
                <span class="rss-date"><?php echo get_the_date(); ?></span>
            </li>
        <?php endwhile; endif; ?>
        <?php
        $index = 0;
        if ($posts->have_posts()) : while ($posts->have_posts()) : $index++; $posts->the_post(); ?>
            <li>
                <a class="rsswidget" href="<?php echo admin_url() ?>/?page=helsingborgAdminBlogRead&amp;id=<?php the_ID(); ?>"><?php the_title(); ?></a>
                <span class="rss-date"><?php echo get_the_date(); ?></span>
                <div class="rssSummary"><?php if ($index == 1) the_excerpt(); ?></div>
            </li>
        <?php endwhile; endif; ?>
    </ul>
</div>