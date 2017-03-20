<?php

namespace HbgMigrate;

abstract class Shortcode
{
    public $shortcode;
    public $moduleType;

    public function __construct()
    {
        add_action('HbgMigrate/shortcode/' . $this->shortcode, array($this, 'migrate'), 10, 5);
    }

    abstract public function migrate(\WP_Post $post, string $full, string $base, array $attributes = null, string $content = null);

    /**
     * Saves migrated module
     * @param  array  $data The module data
     * @return bool|int
     */
    public function save(array $data, \WP_Post $post, string $shortcodeBefore, $description = null)
    {
        $hash = $this->hash(array($post->ID, $shortcodeBefore));

        $migrated = get_option('hbgmigrate_migrated_shortcode_posts', array());
        $isMigrated = in_array($hash, $migrated);

        // Bail if already migrated
        if ($isMigrated) {
            return false;
        }

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
            $description = 'Migrated shortcode';
        }

        update_post_meta($moduleId, 'module-description', $description);

        // Update postcontent
        $postContent = str_replace($shortcodeBefore, $this->getShortcode($moduleId), $post->post_content);

        wp_update_post(array(
            'ID' => $post->ID,
            'post_content' => $postContent
        ));

        // Add acf fields
        foreach ($acfFields as $key => $value) {
            update_field($key, $value, $moduleId);
        }

        // Add to list of migrated shortcodes
        $migrated[] = $hash;
        update_option('hbgmigrate_migrated_shortcode_posts', $migrated);

        echo 'Migrated shortcode <strong>"' . $shortcodeBefore . '"</strong> for post with id <strong>"' . $post->ID . '"</strong><br>';
        return $moduleId;
    }

    public function getShortcode(int $moduleId)
    {
        return '[modularity id="' . $moduleId . '"]';
    }

    public function hash($what)
    {
        return sha1(serialize($what));
    }
}
