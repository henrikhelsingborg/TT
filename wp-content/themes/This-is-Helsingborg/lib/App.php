<?php

namespace Helsingborg;

use Helsingborg\Theme;
use Helsingborg\Admin;
use Helsingborg\Helper;

class App
{
    public function __construct()
    {
        global $lazyLoadImage;

        // Helpers
        new Helper\Wp;
        new Helper\Ajax;
        new Helper\Rss;

        // Theme
        new Theme\Support;
        new Theme\Enqueue;
        new Theme\Navigation;
        new Theme\WidgetAreas;
        new Theme\GravityForms;
        if (isset($lazyloadImages)) new Theme\LazyLoad;

        // Admin
        new Admin\Enqueue;

        // Metaboxes (loaded from the metabox init class)
        new Metabox\Init;
    }
}