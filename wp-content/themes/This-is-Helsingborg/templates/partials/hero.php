<div class="hero" style="background-image:url(<?php echo get_option('helsingborg_header_image_imageurl'); ?>);">
    <?php
    if (is_front_page()) {
        get_template_part('templates/partials/stripe');
    }

    get_search_form();
    ?>
</div>