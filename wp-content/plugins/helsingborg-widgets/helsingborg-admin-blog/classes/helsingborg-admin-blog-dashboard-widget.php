<?php

class AdminBlogDashboardWidget {

    protected $_viewsPath;

    public function __construct() {
        $this->_viewsPath = HELSINGBORG_ADMIN_BLOG_BASE . 'views/';
        add_action('wp_dashboard_setup', array($this, 'adminBlogDashboardSetup'));
    }

    public function adminBlogDashboardSetup() {
        wp_add_dashboard_widget('AdminBlogDashboard', 'Internblogg', array($this, 'widget'));
    }

    public function widget() {
        // Fetch three latest post in post type
        $posts = new WP_Query(array(
            'post_type' => 'hbgAdminBlog',
            'posts_per_page' => 3,
            'orderby' => 'modified'
        ));

        $sticky = new WP_Query(array(
            'post_type' => 'hbgAdminBlog',
            'meta_query' => array(
                array(
                    'key' => 'is-sticky-post',
                    'value' => true
                )
            )
        ));

        // Display
        $view = 'dashboard-widget.php';
        if ($templatePath = locate_template('templates/plugins/hbg-admin-blog/' . $view)) {
           require($templatePath);
        } else {
            require($this->_viewsPath . $view);
        }
    }

}