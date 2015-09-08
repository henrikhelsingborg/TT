<?php

    define('HELSINGBORG_ADMIN_BLOG_BASE', plugin_dir_path(__FILE__));
    define('HELSINGBORG_ADMIN_BLOG_URL', plugin_dir_url(__FILE__));

    require_once(HELSINGBORG_ADMIN_BLOG_BASE . 'classes/helsingborg-admin-blog-post-type.php');
    require_once(HELSINGBORG_ADMIN_BLOG_BASE . 'classes/helsingborg-admin-blog-dashboard-widget.php');

    new HelsingborgAdminBlogCustomPostType();
    new AdminBlogDashboardWidget();