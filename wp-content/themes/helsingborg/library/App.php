<?php
namespace Helsingborg;

class App
{
    public function __construct()
    {
        //new \Helsingborg\Theme\Enqueue();
        new \Helsingborg\Theme\AdminMenu();
    }
}
