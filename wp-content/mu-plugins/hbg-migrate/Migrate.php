<?php

namespace HbgMigrate;

abstract class Migrate
{
    protected $activeDb = 'to';

    protected $fromDb;
    protected $toDb;

    public function __contsruct()
    {
        global $wpdb, $wpdbFrom;
        $this->toDb = $wpdb;
        $this->fromDb = $wpdbFrom;

        $this->init();
    }

    abstract public function init();
}
