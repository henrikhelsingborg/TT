<?php get_header(); ?>

<div class="content-container">
    <div class="row">
        <div class="columns large-12">
            <?php

                /**
                 * Breadcrumb
                 */
                if (!is_front_page()) {
                    the_breadcrumb();
                }

                /**
                 * If this is the front_page, only show content if there is any
                 * If this is not the front_page, always show the content
                 */
                the_post();
                if ((is_front_page() && strlen(get_the_content()) > 0) || !is_front_page()) {
                    get_template_part('templates/partials/article', 'content');
                } else {
                    get_template_part('templates/partials/accessability', 'menu');
                }

                /**
                 * Widget content-area
                 */
                if ((is_active_sidebar('content-area') == true)) {
                    dynamic_sidebar("content-area");
                }
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>