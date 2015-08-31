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

    <script>var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>

    <?php wp_head(); ?>
</head>
<body <?php echo (is_404()) ? 'id="page-not-found"' : ''; ?>>
    <div class="site-wrapper">
        <a href="#main" class="btn btn-default btn-offcanvas" tabindex="1">Hoppa till innehållet</a>

        <div data-prompt-wrapper="alert"></div>

        <header class="site-header">
            <div class="container">
                <div class="row">
                    <div class="columns large-12">
                        <nav class="nav-topmenu">
                        <?php
                            /**
                             * Displays the top menu navigation
                             */
                            wp_nav_menu(array(
                                'theme_location'  => 'top-menu',
                                'container'       => '',
                                'container_class' => '',
                                'items_wrap'      => '<ul class="navbar-topmenu">%3$s</ul>'
                            ));

                            if (!is_front_page()) get_search_form();
                        ?>
                        </nav>

                        <a href="/" class="logotype"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/helsingborg.svg" alt="Helsingborg Stad"></a>
                        <button class="btn btn-mobile-menu" data-action="toggle-mobile-menu"><i class="hbg-hamburger"></i><span>Meny</span></button>
                        <div class="clearfix"></div>
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
        </header>

        <div class="mobile-menu-wrapper">
            <div class="stripe"></div>
            <?php
                get_template_part('templates/partials/mobile', 'search');
                get_template_part('templates/partials/mobile', 'navigation');
            ?>
        </div>

        <?php
            if (is_front_page()) {
                get_template_part('templates/partials/hero');
            }
        ?>

        <main id="main">
