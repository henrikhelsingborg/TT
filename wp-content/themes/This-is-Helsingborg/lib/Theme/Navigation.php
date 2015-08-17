<?php

namespace Helsingborg\Theme;

class Navigation
{
    public function __construct()
    {
        self::registerMenus();
    }

    public static function registerMenus()
    {
        register_nav_menus(array(
            'main-menu' => 'Huvudmeny',
            'top-menu' => 'Toppmeny',
            'footer-menu' => 'Hjälpmeny'
        ));
    }
}