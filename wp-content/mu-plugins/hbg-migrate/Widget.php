<?php

namespace HbgMigrate;

abstract class Widget
{
    public $widgetType;
    public $moduleType;

    public function __construct()
    {
        add_action('HbgMigrate/widget/' . $this->widgetType, array($this, 'migrate'), 10, 2);
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
     * @return bool|int
     */
    public function save(array $data, int $postId, string $widgetId, string $sidebar, $description = null)
    {
        $migrated = get_option('hbgmigrate_migrated_widgets', array());
        $isMigrated = in_array($widgetId, $migrated);

        // Bail if already migrated
        if ($isMigrated) {
            echo '<span style="color:#ff0000;">ALDREADY MIGRATED, ' . $widgetId . '</span><br>';
            return false;
        }

        // Check if sidebar should be remapped
        $sidebar = $this->remapSidebar($sidebar, $postId);

        $acfFields = array();
        if (isset($data['acf'])) {
            $acfFields = $data['acf'];
            unset($data['acf']);
        }

        $data['post_type'] = $this->moduleType;
        $data['post_status'] = 'publish';

        // Save the module
        $moduleId = wp_insert_post($data);

        if (!$moduleId) {
            echo '<span style="color:#ff0000;">MODULE NOT SAVED, SHIT HAPPENS</span><br>';
            return false;
        }

        if (!$description) {
            $description = 'Migrated';
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
        $migrated[] = $postId . '-' . $widgetId;
        update_option('hbgmigrate_migrated_widgets', $migrated);

        echo 'Migrated widget <strong>"' . $widgetId . '"</strong> of type <strong>"' . $this->widgetType . '"</strong> for post with id <strong>"' . $postId . '"</strong><br>';

        return $moduleId;
    }

    /**
     * Remap sidebars
     * @param  string $sidebar Default sidebbar
     * @param  int    $postId  Post id
     * @return string          Modified sidebar
     */
    public function remapSidebar(string $sidebar, int $postId)
    {
        $postType = get_post_type($postId);
        $template = get_post_meta($postId, '_wp_page_template', true);

        // slider-area => content-area-top
        if ($sidebar === 'slider-area' && $postType === 'page' && (!$template|| $template === 'default')) {
            return 'content-area-top';
        }

        return $sidebar;
    }

    /**
     * Uploads image to use in module
     * @param  string $url    Image to upliad to media gallery (url)
     * @param  int $postId    Post id of the module
     * @return int            Attachment id
     */
    public function saveImageFromUrl(string $url, int $postId) : int
    {
        // Upload paths
        $uploadDir = wp_upload_dir();
        $uploadDir = $uploadDir['path'];

        if (!is_dir($uploadDir)) {
            throw new \Error('No upload folder!');
        }

        $filename = basename($url);

        // Bail if image already exists in library
        if ($attachmentId = $this->attatchmentExists($uploadDir . '/' . basename($filename))) {
            return $attachmentId;
        }

        // Save file to server
        $contents = file_get_contents($url);
        $save = fopen($uploadDir . '/' . $filename, 'w');
        fwrite($save, $contents);
        fclose($save);

        // Detect filetype
        $filetype = wp_check_filetype($filename, null);

        // Insert the file to media library
        $attachmentId = wp_insert_attachment(
            array(
                'guid' => $uploadDir . '/' . basename($filename),
                'post_mime_type' => $filetype['type'],
                'post_title' => $filename,
                'post_content' => '',
                'post_status' => 'inherit'
            ),
            $uploadDir . '/' . $filename,
            $postId
        );

        // Generate attachment meta
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attachData = wp_generate_attachment_metadata($attachmentId, $uploadDir . '/' . $filename);
        wp_update_attachment_metadata($attachmentId, $attachData);

        return $attachmentId;
    }

    /**
     * Checks if a attachment src already exists in media library
     * @param  string $src Media url
     * @return mixed
     */
    protected function attatchmentExists(string $src)
    {
        global $wpdb;
        $query = "SELECT ID FROM {$wpdb->posts} WHERE guid = '$src'";
        $id = $wpdb->get_var($query);

        if (!empty($id) && $id > 0) {
            return $id;
        }

        return false;
    }
}
