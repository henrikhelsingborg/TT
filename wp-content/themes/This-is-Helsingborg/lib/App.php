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

        new Helper\Wp;
        new Helper\Ajax;
        new Helper\Rss;

        new Theme\Support;
        new Theme\Enqueue;
        new Theme\Navigation;
        new Theme\WidgetAreas;
        if (isset($lazyloadImages)) new Theme\LazyLoad;

        new Admin\Enqueue;

        new Metabox\Init;
    }
}