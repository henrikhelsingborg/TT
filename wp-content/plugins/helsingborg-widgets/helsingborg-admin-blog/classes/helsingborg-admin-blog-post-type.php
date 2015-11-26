<?php

if (!class_exists('HelsingborgAdminBlogCustomPostType')) {

    class HelsingborgAdminBlogCustomPostType {

        /**
         * Construct function
         */
        public function __construct() {

            /**
             * Set the viewsPath
             */
            $this->_viewsPath = HELSINGBORG_ADMIN_BLOG_BASE . 'views/';

            /**
             * Runs the registerGalleryPostType() on init hook
             */
            add_action('init', array($this, 'registerAdminBlogPostType'));
            add_action('init', array($this, 'addRoleCaps'));
            add_action('admin_menu', array($this, 'readPage'));

            add_action('save_post', array($this, 'stickyMetaBoxSave'));
        }

        /**
         * Add the roles
         */
        public function addRoleCaps() {
            $roles = array('administrator', 'editor', 'author');

            foreach ($roles as $role) {

                $role = get_role($role);

                if (empty( $role)) {
                    continue;
                }

                $role->add_cap('admin_blog_read');

                if ($role->name == 'administrator') {
                    // Publish
                    $role->add_cap('admin_blogs_publish');

                    // Edit
                    $role->add_cap('admin_blogs_edit');
                    $role->add_cap('admin_blogs_edit_others');
                    $role->add_cap('admin_blog_edit');

                    // Delete
                    $role->add_cap('admin_blogs_delete');
                    $role->add_cap('admin_blogs_delete_others');
                    $role->add_cap('admin_blog_delete');

                    // Private
                    $role->add_cap('admin_blogs_read_private');
                }

            }
        }

        /**
         * Registers the custom post type
         * @return void
         */
        public function registerAdminBlogPostType() {

            /**
             * Post type labels
             * @var array
             */
            $labels = array(
                'name'               => _x('Internblogg', 'post type name'),
                'singular_name'      => _x('Internblogg', 'post type singular name'),
                'menu_name'          => __('Internblogg'),
                'add_new'            => __('Skapa nytt'),
                'add_new_item'       => __('Skapa inlägg'),
                'edit_item'          => __('Redigera inlägg'),
                'new_item'           => __('Nytt inlägg'),
                'all_items'          => __('Alla inlägg'),
                'view_item'          => __('Visa inlägg'),
                'search_items'       => __('Sök inlägg'),
                'not_found'          => __('Inga inlägg att visa'),
                'not_found_in_trash' => __('Inga inlägg i papperskorgen'),
            );

            /**
             * Post type arguments
             * @var array
             */
            $args = array(
                'labels'              => $labels,
                'description'         => 'Helsingborg Admin Blog',
                'public'              => true,
                'publicly_queriable'  => false,
                'show_ui'             => true,
                'exclude_from_search' => true,
                'show_in_nav_menus'   => false,
                'rewrite'             => false,
                'menu_position'       => 2,
                'supports'            => array('title', 'editor'),
                'has_archive'         => true,
                'menu_icon'           => 'dashicons-pressthis',
                'capability_type'     => 'hbgAdminBlog',
                'capabilities'        => array(
                    'publish_posts'       => 'admin_blogs_publish',
                    'edit_posts'          => 'admin_blogs_edit',
                    'edit_others_posts'   => 'admin_blogs_edit_others',
                    'delete_posts'        => 'admin_blogs_delete',
                    'delete_others_posts' => 'admin_blogs_delete_others',
                    'read_private_posts'  => 'admin_blogs_read_private',
                    'edit_post'           => 'admin_blog_edit',
                    'delete_post'         => 'admin_blog_delete',
                    'read_post'           => 'admin_blog_read',
                ),
                'register_meta_box_cb' => array($this, 'registerMetaBoxes')
            );

            /**
             * Register post type
             */
            register_post_type('hbgAdminBlog', $args);
        }

        public function registerMetaBoxes() {
            add_meta_box('stickyMetaBox', 'Pinna', array($this, 'stickyMetaBox'), 'hbgAdminBlog', 'side', 'core');
        }

        public function stickyMetaBox($post, $args) {
            $isSticky = get_post_meta($post->ID, 'is-sticky-post')[0];

            if (!$isSticky) {
                echo '<label><input type="checkbox" value="on" name="sticky"> Pinna till toppen (alltid överst)</label>';
            } else {
                echo '<label><input type="checkbox" value="on" name="sticky" checked> Pinna till toppen (alltid överst)</label>';
            }
        }

        public function stickyMetaBoxSave($post) {
            if (isset($_POST['sticky']) && $_POST['sticky'] == 'on') {
                update_post_meta($post, 'is-sticky-post', true);
            } else {
                update_post_meta($post, 'is-sticky-post', false);
            }
        }

        public function readPage() {
            /**
             * Read page
             */

            add_submenu_page(
                '',
                'Läs internblogg',
                'Test',
                'admin_blog_read',
                'helsingborgAdminBlogRead',
                array($this, 'readPageContent')
            );
        }

        public function readPageContent() {
            global $post;
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) header('location: ' . admin_url());

            $posts = new WP_Query(array(
                'post_type' => 'hbgAdminBlog',
                'p' => $_GET['id']
            ));

            $posts->the_post();

            $view = 'read-page.php';
            if ($templatePath = locate_template('templates/plugins/hbg-admin-blog/' . $view)) {
               require($templatePath);
            } else {
                require($this->_viewsPath . $view);
            }
        }
    }
}