<?php get_header(); ?>

<div class="content-container">
    <div class="row">
        <div class="main-content columns large-8 medium-12">
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
                    echo '<aside class="content-area widgets-test-color row clearfix">';
                    dynamic_sidebar("content-area");
                    echo '</aside>';
                }

                /**
                 * Comments
                 */
                if (comments_open()) {
                    comments_template();
                }
            ?>
        </div>

        <?php
            /**
             * Include sidebar here if welcome text does not exist
             * - If it's exists sidebar will be included in templates/partials/header-welcome.php instead
             */
            global $has_welcome_text;
            if ($has_welcome_text) echo '<div class="hide-for-large-up">';
            get_template_part('templates/partials/sidebar', 'right');
            if ($has_welcome_text) echo '</div>';
        ?>
    </div>
</div>

<?php get_footer(); ?>