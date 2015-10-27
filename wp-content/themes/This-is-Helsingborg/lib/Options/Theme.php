<?php

namespace Helsingborg\Options;

class Theme
{
    public function __construct()
    {
        add_action('init', array($this, 'createThemeOptionsPage'));
    }

    public function createThemeOptionsPage()
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page();
        } else {
            trigger_error('You need to install Advanced Custom Fields!');
        }
    }
}
