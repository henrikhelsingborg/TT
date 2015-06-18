<?php

function Helsingborg_sidebar_widgets() {

    register_sidebar(array(
        'id' => 'footer-area',
        'name' => __('Footerarea', 'Helsingborg'),
        'description' => __('Arean längst ner', 'Helsingborg'),
        'before_widget' => '<div class="left large-4 medium-4 columns"><div class="footer-content">',
        'after_widget' => '</div></div>',
        'before_title' => '<h2 class="footer-title">',
        'after_title' => '</h2>'
    ));

    register_sidebar(array(
        'id' => 'slider-area',
        'name' => __('Topparea', 'Helsingborg'),
        'description' => __('Lägg till de sliders som ska visas på sidan.', 'Helsingborg'),
        'before_widget' => '<div class="large-6 medium-6 columns"><div class="box widget">',
        'after_widget' => '</div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    register_sidebar(array(
        'id' => 'content-area',
        'name' => __('Innehållsarea', 'Helsingborg'),
        'description' => __('Lägg till det som ska visas under innehållet.', 'Helsingborg'),
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>'
    ));

    register_sidebar(array(
        'id' => 'content-area-bottom',
        'name' => __('Innehåll bottenarea', 'Helsingborg'),
        'description' => __('Lägg till det som ska visas under "Innehållsarea".', 'Helsingborg')
    ));

    register_sidebar(array(
        'id' => 'left-sidebar',
        'name' => __('Vänster area', 'Helsingborg'),
        'description' => __('Lägg till de widgets som ska visas i högra sidebaren.', 'Helsingborg'),
        'before_widget' => '<div class="widget large-12 medium-6 columns"><div class="widget-content">',
        'after_widget' => '</div></div>',
        'before_title' => '<h2>',
        'after_title' => '</h2><div class="divider"><div class="upper-divider"></div><div class="lower-divider"></div></div>'
    ));

    register_sidebar(array(
        'id' => 'left-sidebar-bottom',
        'name' => __('Vänster bottenarea', 'Helsingborg'),
        'description' => __('Lägg till de widgets som ska visas i högra sidebaren.', 'Helsingborg'),
        'before_widget' => '<div class="widget large-12 medium-6 columns"><div class="widget-content">',
        'after_widget' => '</div></div>',
        'before_title' => '<h2>',
        'after_title' => '</h2><div class="divider"><div class="upper-divider"></div><div class="lower-divider"></div></div>'
    ));

    register_sidebar(array(
        'id' => 'right-sidebar',
        'name' => __('Höger area', 'Helsingborg'),
        'description' => __('Lägg till de widgets som ska visas i högra sidebaren.', 'Helsingborg'),
        'before_widget' => '<div class="widget large-12 medium-6 columns"><div class="widget-content">',
        'after_widget' => '</div></div>',
        'before_title' => '<h2>',
        'after_title' => '</h2><div class="divider"><div class="upper-divider"></div><div class="lower-divider"></div></div>'
    ));
}
add_action('widgets_init', 'Helsingborg_sidebar_widgets');

?>