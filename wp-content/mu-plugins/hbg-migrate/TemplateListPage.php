<?php

namespace HbgMigrate;

class TemplateListPage extends \HbgMigrate\Template
{
    public $template = 'list-page.php';
    public $moduleType = 'mod-posts';

    public function migrate(string $template, \WP_Post $post)
    {
        $columns = $this->getColumns($post);
        $pages = $this->getPages($post, $columns);

        $firstIsTitle = $this->isFirstColumnTheTitle($columns, $pages);

        $titleColumn = '';
        if ($firstIsTitle) {
            $titleColumn = array_values($columns)[0];
            $titleColumn = array_values($titleColumn)[0];

            $columns = array_shift($columns);
        }

        // Setup the module data
        $moduleData = array(
            'post_title' => '',
            'post_content' => '',
            'acf' => array(
                'field_571dfd4c0d9d9' => 'expandable-list', // posts_display_as
                'field_57e3bcae3826e' => $titleColumn, // title_column_label
                'field_571f5776592e6' => array_values($columns),
                'field_571dfaafe6984' => 'manual', // posts_data_source
                'field_571dfc6ff8115' => $this->getPagesIds($pages), // posts_data_posts
                'field_571dff4eb46c3' => -1, // posts_count
            )
        );

        // Add column values as postmeta to posts in the list
        $postmeta = array();
        foreach ($pages as $page) {
            if (!isset($page->list_columns) || empty($page->list_columns)) {
                continue;
            }

            $postmeta[$page->ID] = $page->list_columns;
        }

        $this->save($moduleData, $postmeta, $post->ID);
    }

    public function isFirstColumnTheTitle($columns, $pages)
    {
        $firstColumn = array_values($columns)[0];
        $firstColumn = array_values($firstColumn)[0];
        $firstColumn = sanitize_title($firstColumn);

        foreach ($pages as $page) {
            if ($page->list_columns[$firstColumn] !== $page->post_title) {
                return false;
            }
        }

        return true;
    }

    /**
     * Saves migrated module
     * @param  array  $data The module data
     * @return bool|int
     */
    public function save(array $data, $postmeta, int $postId, $description = null)
    {
        $migrated = get_option('hbgmigrate_migrated_templates', array());
        $isMigrated = in_array($postId, $migrated);

        // Bail if already migrated
        if ($isMigrated) {
            return false;
        }

        foreach ($postmeta as $key => $value) {
            update_post_meta($key, 'modularity-mod-posts-expandable-list', $value);
        }

        // Check if sidebar should be remapped
        $sidebar = 'content-area';

        $acfFields = array();
        if (isset($data['acf'])) {
            $acfFields = $data['acf'];
            unset($data['acf']);
        }

        $data['post_type'] = $this->moduleType;
        $data['post_status'] = 'publish';

        // Save the module
        $moduleId = wp_insert_post($data);

        if (!$description) {
            $description = 'Migrated ListPage Template';
        }

        update_post_meta($moduleId, 'module-description', $description);

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
            'postid' => (string) $moduleId
        );

        update_post_meta($postId, 'modularity-modules', $pageModules);

        // Add acf fields
        foreach ($acfFields as $key => $value) {
            update_field($key, $value, $moduleId);
        }

        // Add widget to list of completed migrations
        $migrated[] = $postId;
        update_option('hbgmigrate_migrated_templates', $migrated);

        echo 'Migrated template for post <strong>"' . $postId . '"</strong><br>';

        return $moduleId;
    }

    /**
     * Get pages that should be in the list
     * @param  WP_POst  $post    The post object
     * @param  array  $columns Post columns
     * @return array
     */
    public function getPages($post, $columns)
    {
        $pages = get_pages(array(
            'sort_order' => 'DESC',
            'sort_column' => 'post_modified',
            'child_of' => $post->ID,
            'post_type' => 'page',
            'post_status' => 'publish',
        ));

        foreach ($pages as &$page) {
            $page->list_columns = array();

            foreach ($columns as $key => $column) {
                $meta = get_post_meta($page->ID, '_helsingborg_meta', true);

                if (is_array($meta)) {
                    $data = isset($meta['article_options_' . $key]) && !empty($meta['article_options_' . $key]) ? $meta['article_options_' . $key] : '-';
                }

                $page->list_columns[sanitize_title(end($column))] = $data;
            }
        }

        return $pages;
    }

    /**
     * Get ids from posts array
     * @param  array $pages Array with WP_POsts
     * @return array        Array with post ids
     */
    public function getPagesIds($pages)
    {
        $ids = array();

        foreach ($pages as $page) {
            $ids[] = $page->ID;
        }

        return $ids;
    }

    public function getColumns(\WP_Post $post)
    {
        $columnValues = $this->getAvailableColumns();
        $meta = get_post_meta($post->ID, '_helsingborg_meta', true);

        if (!is_array($meta)) {
            return;
        }

        $columns = explode(',', $meta['list_options']);
        $retColumns = array();

        foreach ($columns as $key) {
            $key = trim($key);

            if (!isset($columnValues[$key])) {
                continue;
            }

            $retColumns[$key] = array(
                'field_571f5790592e7' => $columnValues[$key] // header-title
            );
        }

        return $retColumns;
    }

    public function getAvailableColumns()
    {
        global $wpdbFrom;
        $columns = $wpdbFrom->get_results("SELECT title FROM list_categories ORDER BY id ASC", OBJECT);

        $list = array();

        if (!empty($columns)) {
            foreach ($columns as $item) {
                $list[] = $item->title;
            }
        }

        return $list;
    }
}

new \HbgMigrate\TemplateListPage();
