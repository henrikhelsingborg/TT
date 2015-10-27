<?php

namespace HbgInherit\Widget;

use WP_Widget;

class InheritContent extends WP_Widget
{

    /**
     * Constructor
     */
    public function __construct()
    {
        // Enqueue javascript
        add_action('admin_enqueue_scripts', array($this, 'enqueueFiles'));

        // Load posts ajax
        add_action('wp_ajax_hbgInheritLoadPosts', array($this, 'loadInheritContent'));

        // Widget arguments
        parent::__construct(
            'HelsingborgPostInheritWidget',
            '* Arvsinnehåll',
            array(
                "description" => __('Visar innehåll från en specifik arvspost')
            )
        );
    }

    public function enqueueFiles($hook)
    {
        wp_enqueue_script(
            'helsingborg-post-inherit-widget-javascript',
            plugins_url('helsingborg-inherit/source/js/helsingborg-inherit-widget.js'),
            array('jquery'),
            false,
            true
        );
    }

    /**
     * Renders the text widget form
     * @param  object $instance The current widget instance
     * @return void
     */
    public function form($instance)
    {
        require \HbgInherit\Helper\Wp::getTemplate('widget-form');
    }

    /**
    * Prepare widget options for save
    * @param  array $newInstance The new widget options
    * @param  array $oldInstance The old widget options
    * @return array              The merged instande of new and old to be saved
    */
    public function update($newInstance, $oldInstance)
    {
        return $newInstance;
    }

    /**
     * Display the widget markup
     * @param  array $args     The widget arguments
     * @param  array $instance The widget instance
     * @return void            The widget markup
     */
    public function widget($args, $instance)
    {
        extract($args);

        $post = get_post($instance['post_id']);
        setup_postdata($post);

        require \HbgInherit\Helper\Wp::getTemplate('widget-' . $instance['post_type']);
    }

    /**
     * Searches for inhert widget content
     * @return [type] [description]
     */
    public function loadInheritContent()
    {
        global $wpdb;

        $title = $_POST['q'];
        $postType = $_POST['type'];

        $query = "SELECT ID, post_title
                  FROM $wpdb->posts
                  WHERE post_type = '" . $postType . "'
                  AND post_status = 'publish'
                  AND LOWER(post_title) LIKE '%" . strtolower($title) . "%'";

        //echo $query;

        $posts = $wpdb->get_results($query);

        foreach ($posts as $post) {
            $list .= '<option value="' . $post->ID . '">';
            $list .= $post->post_title . ' (' . $post->ID . ')';
            $list .= '</option>';
        }

        echo $list;
        die();
    }
}
