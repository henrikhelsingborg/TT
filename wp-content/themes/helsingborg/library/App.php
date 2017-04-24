<?php
namespace Helsingborg;

class App
{
    public function __construct()
    {
        new \Helsingborg\Theme\AdminMenu();

        add_filter('single_template', array($this, 'updateTemplate'), 20);
    }

    public function updateTemplate($template_path)
    {
        if ($post_type = get_post_type()) {
            if (get_post_type_object($post_type)->hierarchical == true && $post_type_object->_builtin == false) {
                $template_path = \Municipio\Helper\Template::locateTemplate('page');
            }
        }

        return($template_path);
    }
}
