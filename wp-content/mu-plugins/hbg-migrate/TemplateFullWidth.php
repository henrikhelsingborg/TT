<?php

namespace HbgMigrate;

class TemplateFullWidth extends \HbgMigrate\Template
{
    public $template = 'full-width-page.php';
    public $templateTo = 'full-width.blade.php';
}

new \HbgMigrate\TemplateFullWidth();
