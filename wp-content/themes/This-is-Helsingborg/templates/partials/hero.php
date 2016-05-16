<div class="hero" style="background-image:url(<?php echo get_option('helsingborg_header_image_imageurl'); ?>);">
    <?php
    if (is_front_page()) {
        get_template_part('templates/partials/stripe');
    }

    get_search_form();
    ?>

    <!-- Google Search Form -->
    <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "WebSite",
      "url": "<?php echo home_url(); ?>",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "http://www.helsingborg.se/?s={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
    </script>
</div>
