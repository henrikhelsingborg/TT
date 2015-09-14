<?php

if (!class_exists('HbgTeaser')) {
    class HbgTeaser extends WP_Widget {

        private $_viewsPath;

        /**
         * Constructor
         */
        function __construct() {
            // Widget arguments
            parent::__construct(
                'HelsingborgTeaserWidget',
                '* Teaser',
                array(
                    "description" => __('Visar en teaser med ikon, text och länk')
                )
            );

            $this->_viewsPath = plugin_dir_path(plugin_dir_path(__FILE__)) . 'views/';
        }

        /**
         * Displays the widget
         * @param  array $args     Arguments
         * @param  array $instance Instance
         * @return void
         */
        public function widget($args, $instance) {
            extract($args);

            // View
            $view = 'widget.php';
            if ($templatePath = locate_template('templates/plugins/hbg-teaser/' . $view)) {
                require($templatePath);
            } else {
                require($this->_viewsPath . $view);
            }
        }

        /**
        * Prepare widget options for save
        * @param  array $newInstance The new widget options
        * @param  array $oldInstance The old widget options
        * @return array              The merged instande of new and old to be saved
        */
        public function update($newInstance, $oldInstance) {
            return $newInstance;
        }

        /**
         * Displays widget form
         * @param  array $instance The instance
         * @return void
         */
        public function form ($instance) {
            require($this->_viewsPath . 'widget-form.php');
        }
    }
}