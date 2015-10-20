<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
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

    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/icons/favicon.ico" type="image/x-icon">

    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/assets/images/icons/apple-touch-icon-144x144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/assets/images/icons/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/assets/images/icons/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo get_template_directory_uri(); ?>/assets/images/icons/apple-touch-icon-precomposed.png">

    <script>
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        <?php if (is_front_page()) : ?>var is_front_page = true;<?php endif; ?>
        <?php if (isset($lazyloadImages) && $lazyloadImages === true) : ?>var lazyloadImages = true;<?php endif; ?>
    </script>

    <?php wp_head(); ?>
</head>
<body <?php echo (is_404()) ? 'id="page-not-found"' : ''; ?> class="<?php echo (is_front_page()) ? 'is-front-page' : ''; ?>" data-theme="<?php echo get_option('helsingborg_color_theme'); ?>">
    <div class="site-wrapper">
        <a href="#main" class="btn btn-default btn-offcanvas" tabindex="1">Hoppa till innehållet</a>

        <div data-prompt-wrapper="alert"></div>

        <header class="site-header">
            <div class="container">
                <div class="row">
                    <div class="columns large-12">
                        <a href="/" class="logotype" data-tooltip="hover">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/helsingborg.svg" alt="Helsingborg Stad" width="239" height="68">
                            <span class="tooltip" style="width:131px;">
                                Gå till startsidan
                            </span>
                        </a>

                        <nav class="nav-topmenu">
                        <?php

                            /*
                            echo '<ul class="navbar-topmenu-help">';
                            wp_nav_menu(array(
                                'theme_location'  => 'top-menu-help',
                                'container'       => '',
                                'container_class' => '',
                                'items_wrap'      => '%3$s'
                            ));
                            echo '</ul><br>';
                            */

                            /**
                             * Displays the top menu navigation
                             */
                            wp_nav_menu(array(
                                'theme_location'  => 'top-menu',
                                'container'       => '',
                                'container_class' => '',
                                'items_wrap'      => '<ul class="navbar-topmenu">%3$s</ul>'
                            ));

                            echo '<br>';

                            get_search_form();
                        ?>
                        </nav>

                        <a href="/" class="logotype logotype-mobile">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/helsingborg.svg" alt="Helsingborg Stad">
                        </a>

                        <button class="btn btn-mobile-menu" data-action="toggle-mobile-menu"><i class="hbg-hamburger"></i><span>Meny</span></button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="nav-mainmenu-container">
                <div class="container">
                    <div class="row">
                        <div class="columns large-12">
                            <?php
                                /**
                                 * Displays the main menu navigation
                                 */
                                wp_nav_menu(array(
                                    'theme_location'  => 'main-menu',
                                    'container'       => 'nav',
                                    'container_class' => 'navbar navbar-mainmenu',
                                    'items_wrap'      => '<ul class="nav">%3$s</ul>',
                                    'depth'           => 1
                                ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mobile-menu-wrapper">
                <?php
                    get_template_part('templates/partials/stripe');
                    get_template_part('templates/partials/mobile', 'navigation');
                ?>
            </div>

            <?php
                if (is_front_page()) {
                    get_template_part('templates/partials/hero');
                }
            ?>
        </header>

        <main id="main">
