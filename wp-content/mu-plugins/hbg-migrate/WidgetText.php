<?php

namespace HbgMigrate;

class WidgetText extends \HbgMigrate\Migrate
{
    public function __construct()
    {
        parent::__contsruct();
    }

    public function init()
    {
        $textWidgets = $this->fromDb->get_results("SELECT * FROM wp_options WHERE option_name REGEXP '^widget_([0-9]+)_text'");
        var_dump($textWidgets);

        exit;
    }
}

new \HbgMigrate\WidgetText();
