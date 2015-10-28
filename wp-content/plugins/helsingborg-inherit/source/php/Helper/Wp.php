<?php

namespace HbgInherit\Helper;

class Wp
{
    public static function getTemplate($slug = '', $error = true)
    {
        $paths = apply_filters('HbgInherit/TemplatePath', array(
            get_stylesheet_directory() . '/templates/plugins/' . HBG_INHERIT_TEMPLATE_FOLDER . '/',
            get_template_directory() . '/templates/plugins/' . HBG_INHERIT_TEMPLATE_FOLDER . '/',
            HBG_INHERIT_PATH . 'views/'
        ));

        foreach ($paths as $path) {
            $file = $path . $slug . '.php';

            if (file_exists($file)) {
                return $file;
            }
        }

        if ($error) {
            trigger_error(
                'HbgInherit: Template ' . $slug .
                '.php not found in any of the paths: ' . var_export($paths, true),
                E_USER_WARNING
            );
        }
    }
}
