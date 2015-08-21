<?php

namespace Helsingborg\Helper;

class Ajax {
    public function __construct()
    {
        // Search
        add_action('wp_ajax_nopriv_search', '\Helsingborg\Helper\Ajax::search_callback');
        add_action('wp_ajax_search', '\Helsingborg\Helper\Ajax::search_callback');

        // Search WP Query
        add_action('wp_ajax_nopriv_search_pages', '\Helsingborg\Helper\Ajax::search_pages_callback');
        add_action('wp_ajax_search_pages', '\Helsingborg\Helper\Ajax::search_pages_callback');

        // Widget url issue
        add_action('wp_ajax_fix_widget_data', '\Helsingborg\Helper\Ajax::fix_widget_data_callback');

        // Load pages
        add_action('wp_ajax_load_pages', '\Helsingborg\Helper\Ajax::load_pages_callback');
        add_action('wp_ajax_load_pages_rss', '\Helsingborg\Helper\Ajax::load_pages_rss_callback');
    }

    /**
     * Google custom search
     * @return json Search result
     */
    public static function search_callback() {
        $key       = 'AIzaSyCMGfdDaSfjqv5zYoS0mTJnOT3e9MURWkU';
        $cx        = '016534817360440217175:ndsqkc_wtzg';
        $index     = $_POST['index'];
        $keyword   = $_POST['keyword'];

        $url = 'https://www.googleapis.com/customsearch/v1?key=' . $key . '&cx=' . $cx . '&q=' . urlencode($keyword) . '&hl=sv&siteSearchFilter=i&alt=json&start=' . $index;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($ch);
        curl_close($ch);
        echo $result;

        die();
    }

    /**
     * Search pages with wp query
     * @return json Search result
     */
    public static function search_pages_callback() {
        $s = $_POST['s'];
        $result = array();

        $args = array(
            's' => $s,
            'post_type' => 'page',
            'posts_per_page' => 5,
            'post_status' => 'publish'
        );

        $pages = new WP_Query($args);

        foreach ($pages->posts as $page) {
            $result[$page->ID]['page'] = $page;
            $result[$page->ID]['permalink'] = get_permalink($page->ID);
            $result[$page->ID]['excerpt'] = get_excerpt_by_id($page->ID);
        }

        echo json_encode($result);
        wp_die();
    }

    /**
     * Fixes issue with url being wrong inside of widgets, replace all occerrences here
     * @return void
     */
    public static function fix_widget_data_callback() {
        global $wpdb;
        $from = $_POST['from'];
        $to   = $_POST['to'];

        if (count($from) < 1 || count($to) < 1) {
            echo ('Värde saknas!'); die();
        }

        for ($i=1;$i<=125;$i++) {
            $wp_table = $i == 1 ? 'wp_options' : 'wp_' . $i . '_options';

            // Fetch list with those containing the searched value
            $option_ids_query = "SELECT option_id FROM $wp_table WHERE option_name LIKE '%widget%' AND option_value LIKE '%" . $from . "%'";
            $option_ids = $wpdb->get_results($option_ids_query, ARRAY_A);

            // Iterate through all option_ids and go through its data
            foreach ($option_ids as $option_id) {

                // Get the data
                $option_value_query = "SELECT option_value FROM $wp_table WHERE option_id = " . $option_id['option_id'];
                $option_value = $wpdb->get_results($option_value_query, OBJECT)[0]->option_value;

                // Separate values
                $value_array = explode(';', $option_value);

                // Go through each complete value
                foreach($value_array as $key => $value) {
                    if (strpos($value, $from) !== false) {
                        // Get the proper values
                        preg_match('/s:(\d+):"(.*?)"/', $value, $matches);

                        // Update url with new parameters
                        $new_url = str_replace($from, $to, $matches[2]);

                        // Now update complete string
                        $value_array[$key] = self::update_url_and_value($value, $new_url);
                    }
                }

                // Now pack it together and save in DB
                $option_value = implode(';', $value_array);
                $result = $wpdb->update(
                                    $wp_table,
                                    array('option_value' => $option_value),
                                    array('option_id' => $option_id['option_id'])
                                );
            }

            if ($result) { echo 'Uppdaterade - ' . $wp_table . '<br>'; } else { echo 'Ingen uppdatering skedde för ' . $wp_table . '<br>'; }
        }

        die();
    }

    /**
     * Updates the url in widget
     * @param  [type] $obj       [description]
     * @param  [type] $new_value [description]
     * @return [type]            [description]
     */
    public static function update_url_and_value($obj, $new_value) {
        $updated_value = preg_replace('/s:(\d+):\\"(.*?)\\"/', 's:'. strlen($new_value) . ':"' . $new_value . '"', $obj );
        return $updated_value;
    }

    /**
     * Displays a selectbox with pages from a search on post_title
     * @return void
     */
    public static function load_pages_callback() {
        global $wpdb;

        $title     = $_POST['title'];
        $id        = $_POST['id'];
        $name      = $_POST['name'];

        $pages = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE post_type = 'page' AND post_title LIKE '%" . $title . "%'");

        $list = '<select id="' . $id . '" name="' . $name . '">';

        foreach ($pages as $page) {
            $list .= '<option value="' . $page->ID . '">';
            $list .= $page->post_title . ' (' . $page->ID . ')';
            $list .= '</option>';
        }

        $list .= '</select>';

        echo $list;
        die();
    }

    /**
     * Displays a selectbox with pages from a search on post_title
     * @return void
     */
    public function load_pages_rss_callback() {
        global $wpdb;
        $title     = $_POST['title'];

        $pages = $wpdb->get_results("SELECT ID, post_title
                             FROM $wpdb->posts
                             WHERE post_type = 'page'
                             AND post_title LIKE '%" . $title . "%'");

        $list = '<select onchange="updateValues();" id="rss_select" name="rss_select">';
        $list .= '<option value="-1">' . __(" -- Välj sida i listan -- ") . '</option>';

        foreach ($pages as $page) {
            $list .= '<option value="' . $page->ID . '">';
            $list .= $page->post_title . ' (' . $page->ID . ')';
            $list .= '</option>';
        }

        $list .= '</select>';

        echo $list;
        die();
    }
}