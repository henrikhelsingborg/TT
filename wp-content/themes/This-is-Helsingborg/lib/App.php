<?php

namespace Helsingborg;

use Helsingborg\Theme;
use Helsingborg\Admin;
use Helsingborg\Helper;

class App
{
    public function __construct()
    {
        new Helper\Wp;
        new Helper\Ajax;
        new Helper\Rss;

        new Theme\Support;
        new Theme\Enqueue;
        new Theme\Navigation;
        new Theme\WidgetAreas;

        new Admin\Enqueue;
        new Admin\MetaBoxes;
    }
}