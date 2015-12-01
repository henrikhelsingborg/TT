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

        if (!isset($instance['post_type'])) $instance['post_type'] = $post->post_type;
        if (!isset($instance['title'])) $instance['title'] = $post->post_title;

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

    /**
     * Checks if a day is a holiday, if it is return the "day name"
     * @param  string $date The date
     * @return string       The day name if holiday else date
     */
    public function checkHoliday($date)
    {
        $url = 'http://api.dryg.net/dagar/v2.1/' . date('Y', strtotime($date)) . '/' . date('m', strtotime($date)) . '/' . date('d', strtotime($date));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result);

        if (isset($result->dagar[0]->helgdag)) {
            return $result->dagar[0]->helgdag . ' <span class="date">(' . $date . ')</span>';
        } else {
            return $date;
        }
    }
}
