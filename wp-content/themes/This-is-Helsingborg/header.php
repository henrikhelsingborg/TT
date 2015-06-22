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

    <?php wp_head(); ?>
</head>
<body>
    <div class="off-canvas">
        <div class="stripe"></div>
        <div class="container">
            <?php
                get_template_part('templates/partials/mobile', 'search');
                get_template_part('templates/partials/mobile', 'navigation');
            ?>
        </div>
    </div>

    <div class="site-wrapper">
        <header class="site-header">
            <div class="container">
                <div class="row">
                    <div class="columns large-12">
                        <a href="/" class="logotype"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/helsingborg.svg" alt="Helsingborg Stad"></a>
                        <button class="btn btn-mobile-menu" data-action="toggle-mobile-menu"><i class="fa fa-bars"></i></button>
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

        <?php get_template_part('templates/partials/hero');