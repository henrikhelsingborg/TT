<?php

    include_once('classes/helsingborg-teaser-widget.php');
    $hbgTeaser = new HbgTeaser();

    add_action('widgets_init', 'HelsingborgTeaserWidgetRegister');
    function HelsingborgTeaserWidgetRegister() {
        register_widget('HbgTeaser');
    }