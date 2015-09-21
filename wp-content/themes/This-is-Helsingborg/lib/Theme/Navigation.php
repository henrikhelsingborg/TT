<?php

namespace Helsingborg\Theme;

class Navigation
{
    public function __construct()
    {
        self::registerMenus();
    }

    /**
     * Register navigation menus
     * @return void
     */
    public static function registerMenus()
    {
        register_nav_menus(array(
            'main-menu' => 'Huvudmeny',
            'top-menu' => 'Toppmeny',
            'footer-menu' => 'Hjälpmeny'
        ));
    }
}