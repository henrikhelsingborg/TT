<?php

namespace HbgMigrate;

abstract class Widget
{
    public $widgetType;
    public $moduleType;

    public function __construct()
    {
        add_action('HbgMigrate/' . $this->widgetType, array($this, 'migrate'), 10, 2);
    }

    /**
     * Absract migration method
     * @param  array  $data
     * @param  int    $postId
     * @return void
     */
    abstract public function migrate(array $data, int $postId);

    /**
     * Saves migrated module
     * @param  array  $data The module data
     * @return bool
     */
    public function save(array $data, int $postId, string $widgetId, string $sidebar)
    {
        $migrated = get_option('hbgmigrate_migrated_widgets', array());
        $isMigrated = in_array($widgetId, $migrated);

        // Bail if already migrated
        if ($isMigrated) {
            return false;
        }

        $data['post_type'] = $this->moduleType;
        $data['post_status'] = 'publish';

        // Save the module
        $moduleId = wp_insert_post($data);

        // Set modularity option for placing the module on the page
        $pageModules = get_post_meta($postId, 'modularity-modules', true);

        if (!is_array($pageModules)) {
            $pageModules = array();
        }

        if (!isset($pageModules[$sidebar])) {
            $pageModules[$sidebar] = array();
        }

        $pageModules[$sidebar][uniqid()] = array(
            'hidden' => false,
            'columnWidth' => '',
            'postid' => $moduleId
        );

        update_post_meta($postId, 'modularity-modules', $pageModules);

        $migrated[] = $widgetId;
        update_option('hbgmigrate_migrated_widgets', $migrated);

        echo 'Migrated widget <strong>"' . $widgetId . '"</strong> of type <strong>"' . $this->widgetType . '"</strong> for post with id <strong>"' . $postId . '"</strong><br>';

        return true;
    }
}
