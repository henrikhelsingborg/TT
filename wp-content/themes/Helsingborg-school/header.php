<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?> >
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EDGE">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Helsingborg stad</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="pubdate" content="<?php echo the_time('d M Y'); ?>">
    <meta name="moddate" content="<?php echo the_modified_time('d M Y'); ?>">
    <meta name="google-translate-customization" content="10edc883cb199c91-cbfc59690263b16d-gf15574b8983c6459-12">

    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/apple-touch-icon-144x144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/apple-touch-icon-precomposed.png">

    <?php wp_head(); ?>

    <script>
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>

    <?php if (strlen(get_option('helsingborg_color_code')) > 0) : $colorCode = get_option('helsingborg_color_code'); ?>
    <style>
        .nav-bar,
        .main-footer,
        .button-primary,
        article .article-body ul li::before {
            background: <?=$colorCode?> !important;
            background-color: <?=$colorCode?> !important;
        }
    </style>
    <?php endif; ?>
</head>
<body data-theme="<?php echo get_option('helsingborg_color_theme'); ?>">
    <div class="off-canvas-wrap" data-offcanvas>
        <div class="inner-wrap">
            <?php get_template_part('templates/partials/navigation','off-canvas'); ?>

            <div class="main-site-container">
                <header class="header-main">
                    <div class="nav-bar">
                        <div class="row">
                            <div class="large-3 medium-4 small-12 columns logotype">
                                <a href="<?php echo site_url(); ?>"><img class="logotype" src="<?php echo get_option('helsingborg_header_image_imageurl'); ?>" alt="<?php echo bloginfo('name'); ?>"></a>
                            </div>

                            <nav class="nav-mainmenu large-9 medium-8 small-4 columns">
                                <?php get_template_part('templates/partials/navigation', 'main'); ?>
                            </nav>

                            <nav class="mobile-nav" role="navigation">
                                <?php get_template_part('templates/partials/navigation', 'mobile'); ?>
                            </nav>

                            <div class="mobile-search">
                                <div class="mobile-search-input-container">
                                    <form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
                                        <input type="text" class="mobile-search-input" name="s" placeholder="Din S&ouml;kning"/>
                                        <input type="submit" class="mobile-search-btn" value="Sök" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="hero widgets-test-color clearfix">
                        <div class="color-band"></div>
                        <?php
                            /**
                             * Include the slider area
                             */
                            if ((is_active_sidebar('slider-area') == true)) {
                                echo '<div class="slider-area">';
                                dynamic_sidebar('slider-area');
                                echo '</div>';
                            }

                            $image = false;
                            $currPageId = get_the_ID();
                            if (has_post_thumbnail($currPageId)) {
                                $image_id = get_post_thumbnail_id($currPageId);
                                $image = wp_get_attachment_image_src($image_id, 'single-post-thumbnail');
                                $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);

                                echo '<img src="' . $image[0] . '" class="mobile-header-image" alt="' . $alt_text . '">';
                            }
                        ?>

                    </div>

                    <?php
                        /**
                         * Display Welcome section if this is the font page and if the slide widget area has a text widget (uses the first to populate the welcome text)
                         */
                        $welcomeText = get_post_meta($post->ID, 'hbgWelcomeText', true);
                        if (is_front_page() && is_array($welcomeText) && isset($welcomeText['title']) && isset($welcomeText['content']) && isset($welcomeText['display'])) {
                            global $has_welcome_text;
                            $has_welcome_text = true;
                            require(locate_template('templates/partials/header-welcome.php'));
                        }
                    ?>
                </header>