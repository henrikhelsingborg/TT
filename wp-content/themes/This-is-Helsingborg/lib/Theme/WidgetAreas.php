<?php

namespace Helsingborg\Theme;

class WidgetAreas
{
    public function __construct()
    {
        add_action('widgets_init', '\Helsingborg\Theme\WidgetAreas::registerWidgetAreas');
        add_filter('dynamic_sidebar_params', '\Helsingborg\Theme\WidgetAreas::filterContentAreaClassNames');
        //add_filter('sidebars_widgets', '\Helsingborg\Theme\WidgetAreas::shuffleFactsWidgets');
    }

    /**
     * Registers the widget areas
     * @return void
     */
    public static function registerWidgetAreas()
    {
        /**
         * Footer Area
         */
        register_sidebar(array(
            'id'            => 'footer-area',
            'name'          => __('Footerarea', 'Helsingborg'),
            'description'   => __('Arean längst ner på sidan', 'Helsingborg'),
            'before_widget' => '<div class="left large-6 medium-6 print-6 columns"><div class="footer-content">',
            'after_widget'  => '</div></div>',
            'before_title'  => '<h2 class="footer-title">',
            'after_title'   => '</h2>'
        ));

        /**
         * Slider Area
         */
        register_sidebar(array(
            'id'            => 'slider-area',
            'name'          => __('Topparea', 'Helsingborg'),
            'description'   => __('Visas under huvudmenyn', 'Helsingborg'),
            'before_widget' => '<div class="large-12 medium-12 small-12 print-12 columns widget">' .
                               '<div class="box %2$s">',
            'after_widget'  => '</div></div>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>'
        ));

        /**
         * Content Area
         */
        register_sidebar(array(
            'id'            => 'content-area',
            'name'          => __('Innehållsarea', 'Helsingborg'),
            'description'   => __('Visas strax under en artikels brödtext', 'Helsingborg'),
            'before_widget' => '<div class="box box-outlined widget %2$s">',
            'after_widget'  => '</div>'
        ));

        /**
         * Content Area Bottom
         */
        register_sidebar(array(
            'id'            => 'content-area-bottom',
            'name'          => __('Innehåll bottenarea', 'Helsingborg'),
            'description'   => __('Visas under vänstermeny och artikel (fullbredd) ', 'Helsingborg'),
            'before_widget' => '<div class="large-12 medium-12 small-12 print-12 columns widget">' .
                               '<div class="box box-outlined %2$s">',
            'after_widget'  => '</div>'
        ));

        /**
         * Service Area
         */
        register_sidebar(array(
            'id'            => 'service-area',
            'name'          => __('Servicearea', 'Helsingborg'),
            'description'   => __('De service-länkar som visas i grått fält på startsidan', 'Helsingborg'),
            'before_widget' => '<div class="widget columns large-4 medium-4 small-12 pprint-4">',
            'after_widget'  => '</div>'
        ));

        /**
         * Fun Facts Area
         */
        register_sidebar(array(
            'id'            => 'fun-facts-area',
            'name'          => __('Fakta', 'Helsingborg'),
            'description'   => __('Faktarutor som visas innan footer (visar tre slumpmässiga).', 'Helsingborg'),
            'before_widget' => '<div class="widget columns large-3 medium-3 print-3 left">',
            'after_widget'  => '</div>'
        ));

        /**
         * Left Sidebar
         */
        register_sidebar(array(
            'id'            => 'left-sidebar',
            'name'          => __('Vänster area', 'Helsingborg'),
            'description'   => __('Visas ovanför vänstermenyn.', 'Helsingborg'),
            'before_widget' => '<div class="large-12 medium-12 small-12 print-12 columns widget">' .
                               '<div class="box box-filled widget %2$s">',
            'after_widget'  => '</div></div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));

        /**
         * Left Sidebar Bottom
         */
        register_sidebar(array(
            'id'            => 'left-sidebar-bottom',
            'name'          => __('Vänster bottenarea', 'Helsingborg'),
            'description'   => __('Visas under vänstermenyn.', 'Helsingborg'),
            'before_widget' => '<div class="large-12 medium-12 small-12 print-12 columns widget">' .
                               '<div class="box box-filled widget %2$s">',
            'after_widget'  => '</div></div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));

        /**
         * Right Sidebar
         */
        register_sidebar(array(
            'id'            => 'right-sidebar',
            'name'          => __('Höger area', 'Helsingborg'),
            'description'   => __('Visas i högerspalten.', 'Helsingborg'),
            'before_widget' => '<div class="large-12 medium-12 small-12 print-12 columns widget">' .
                               '<div class="box box-filled widget %2$s">',
            'after_widget'  => '</div></div>',
            'before_title'  => '<h2>',
            'after_title'   => '</h2>'
        ));
    }

    /**
     * Sets the class names in the content area
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    public static function filterContentAreaClassNames($params)
    {
        global $myWidgetNum;

        /**
         * Set column width to 6 on frontpage "featured" section
         */
        if (is_front_page()) {
            preg_match('/(widget_)\w+/', $params[0]['before_widget'], $widgetClass);
            $widgetClass = $widgetClass[0];

            if ($params[0]['id'] == 'slider-area' && is_front_page()) {
                $params[0]['before_widget'] = '<div class="large-6 medium-6 small-12 print-6 columns ' .
                                              $widgetClass . '"><div class="box widget">';
            }

            if ($params[0]['id'] == 'content-area' && is_front_page()) {
                $myWidgetNum++;

                $class = 'class="' . $widgetClass . ' columns ';

                /**
                 * Add classnames to widget
                 */
                switch ($myWidgetNum) {
                    case 1:
                        $class .= 'large-12 ';
                        break;

                    default:
                        $class .= 'large-6 medium-6 small-12 print-6 ';
                        break;
                }

                $params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']);

                if ($myWidgetNum == 1) {
                    $params[0]['before_widget'] = '<div class="row">' . $params[0]['before_widget'];
                    $params[0]['after_widget'] .= '</div>';
                } elseif ($myWidgetNum % 2 == 0) {
                    $params[0]['before_widget'] = '<div class="row">' . $params[0]['before_widget'];
                } elseif ($myWidgetNum % 2 == 1) {
                    $params[0]['after_widget'] .= '</div>';
                }

                return $params;
            }
        }

        return $params;
    }

    /**
     * Randomize the presentation order of widgets
     * @param  array $widgets The widgets in original order
     * @return array          The widgets in random order
     */
    public static function shuffleFactsWidgets($widgets)
    {
        $limit = 3;

        if (!is_admin()) {
            shuffle($widgets['fun-facts-area']);
            $widgets['fun-facts-area'] = array_slice($widgets['fun-facts-area'], 0, $limit);
        }

        return $widgets;
    }
}
