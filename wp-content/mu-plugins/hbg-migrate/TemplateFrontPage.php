<?php

namespace HbgMigrate;

class TemplateFrontPage extends \HbgMigrate\Template
{
    public $template = 'front-page.php';
    public $templateTo = 'default';
}

new \HbgMigrate\TemplateFrontPage();
