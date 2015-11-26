<?php

namespace Helsingborg\Metabox;

class EasyToRead
{
    public function __construct()
    {
        add_action('admin_init', array($this, 'register'));
    }

    public function register()
    {
        add_meta_box('helsingborg_easytoread_meta', 'Lättläst version', array($this, 'view'), 'page', 'side', 'core');
        add_action('save_post', array($this, 'save'));
    }

    public function view()
    {
        global $post;
        $easyRead = get_post_meta($post->ID, 'hbg_easy_to_read', true);

        $templatePath = locate_template('templates/metaboxes/easy-to-read.php');
        require($templatePath);
    }

    public function save($post_id)
    {
        if (isset($_POST['hbg_easy_to_read_link'])
            && filter_var($_POST['hbg_easy_to_read_link'], FILTER_VALIDATE_URL)) {
            update_post_meta($post_id, 'hbg_easy_to_read', $_POST['hbg_easy_to_read_link']);
        } else {
            update_post_meta($post_id, 'hbg_easy_to_read', '');
        }
    }
}
