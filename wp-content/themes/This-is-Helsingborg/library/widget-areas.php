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
        'before_widget' => '<div class="large-12 medium-12 small-12 columns"><div class="box widget">',
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
        'before_widget' => '<div class="widget large-12 medium-12 small-12 columns"><div class="widget-content">',
        'after_widget' => '</div></div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ));

    register_sidebar(array(
        'id' => 'left-sidebar-bottom',
        'name' => __('Vänster bottenarea', 'Helsingborg'),
        'description' => __('Lägg till de widgets som ska visas i högra sidebaren.', 'Helsingborg'),
        'before_widget' => '<div class="widget large-12 medium-12 small-12 columns"><div class="widget-content">',
        'after_widget' => '</div></div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ));

    register_sidebar(array(
        'id' => 'right-sidebar',
        'name' => __('Höger area', 'Helsingborg'),
        'description' => __('Lägg till de widgets som ska visas i högra sidebaren.', 'Helsingborg'),
        'before_widget' => '<div class="widget large-12 medium-12 small-12 columns %2$s"><div class="widget-content">',
        'after_widget' => '</div></div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ));
}
add_action('widgets_init', 'Helsingborg_sidebar_widgets');

function HelsingborgContentAreaClassNames($params) {
    global $myWidgetNum;

    /**
     * Set column width to 6 on frontpage "featured" section
     */
    if ($params[0]['id'] == 'slider-area' && is_front_page()) {
        $params[0]['before_widget'] = '<div class="large-6 medium-6 small-6 columns"><div class="box widget">';
    }

    if ($params[0]['id'] == 'content-area' && is_front_page()) {
        $myWidgetNum++;

        $class = 'class="columns ';

        /**
         * Add classnames to widget
         */
        switch ($myWidgetNum) {
            case 1:
                $class .= 'large-12 ';
                break;

            default:
                $class .= 'large-6 medium-6 small-12 ';
                break;
        }

        $params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']);

        if ($myWidgetNum == 1) {
            $params[0]['before_widget'] = '<div class="row">' . $params[0]['before_widget'];
            $params[0]['after_widget'] .= '</div>';
        } else if ($myWidgetNum % 2 == 0) {
            $params[0]['before_widget'] = '<div class="row">' . $params[0]['before_widget'];
        } else if ($myWidgetNum % 2 == 1) {
            $params[0]['after_widget'] .= '</div>';
        }

        return $params;
    }

    return $params;
}
add_filter('dynamic_sidebar_params', 'HelsingborgContentAreaClassNames');

?>