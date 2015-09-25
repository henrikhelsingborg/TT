<?php

class HbgHelpDb {

    public $tableAnswers = "help_widget_answers";

    public function __construct()
    {
        global $wpdb;
    }

    /**
     * Handles the plugin activation to create database tables
     * @param  boolean $networkwide Is this a network wide activation or not
     * @return void
     */
    public function pluginActivation($networkwide)
    {
        global $wpdb;

        if (function_exists('is_multisite') && is_multisite()) {
            if ($networkwide) {
                // Network wide activation
                // Get all blogs and set up tables for each one of them
                $activeBlog = $wpdb->blogid;
                $blogs = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");

                foreach ($blogs as $blog) {
                    switch_to_blog($blog);
                    $this->setupTable();
                }

                // Switch back to the blog we started at
                switch_to_blog($activeBlog);
            } else {
                $this->setupTable();
            }
        } else {
            $this->setupTable();
        }
    }

    /**
     * Handles deavtivation of the plugin
     * @param  boolean $networkwide Network deactivation or not
     * @return void
     */
    public function pluginDeactivation($networkwide)
    {
        global $wpdb;

        if (function_exists('is_multisite') && is_multisite()) {
            if ($networkwide) {
                // Network wide activation
                // Get all blogs and set up tables for each one of them
                $activeBlog = $wpdb->blogid;
                $blogs = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");

                foreach ($blogs as $blog) {
                    switch_to_blog($blog);
                    
                    if (is_plugin_active('helsingborg-help-widget/helsingborg-help-widget.php')) {
                        $this->destoryTable();
                    }
                }

                // Switch back to the blog we started at
                switch_to_blog($activeBlog);
            } else {
                $this->destoryTable();
            }
        } else {
            $this->destoryTable();
        }
    }

    /**
     * Creates database table on blog level
     * @return void
     */
    public function setupTable()
    {
        global $wpdb;
        $tableName = $wpdb->prefix . $this->tableAnswers;

        if ($wpdb->get_var("SHOW TABLES LIKE '{$tableName}'") != $tableName) {
            
            // Get charset and collation
            $charsetCollate = null;
            if (!empty ($wpdb->charset)) {
                $charsetCollate = "DEFAULT CHARACTER SET {$wpdb->charset}";
            }

            if (!empty ($wpdb->collate)) {
                $charsetCollate .= " COLLATE {$wpdb->collate}";
            }

            // Create table sql
            $sql = "CREATE TABLE IF NOT EXISTS {$tableName} (
                        id INT NOT NULL AUTO_INCREMENT,
                        post_id INT NOT NULL,
                        ip VARCHAR(255) NULL,
                        answer VARCHAR(255) NOT NULL,
                        comment LONGTEXT NULL,
                        comment_type VARCHAR(255) NULL,
                        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        PRIMARY KEY (id)
                ) {$charsetCollate}";

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }
    }

    /**
     * Remove plugin table if it's empty
     * @return void
     */
    public function destoryTable()
    {
        global $wpdb;
        $tableName = $wpdb->prefix . $this->tableAnswers;

        // Drop table if empty
        if ($wpdb->get_var("SELECT COUNT(*) FROM {$tableName}") == 0) {
            $sql = "DROP TABLE IF EXISTS {$tableName}";
            $wpdb->query($sql);
        }
    }

    /**
     * Adds an answer to the database
     * @param  strong $ip          Remote addres (ip)
     * @param  string $answer      The answer
     * @param  string $comment     The comment
     * @param  stront $commentType The comment type
     * @return integer             The inserted id
     */
    public function saveAnswer($ip, $postID, $answer, $comment = null, $commentType = null)
    {
        global $wpdb;

        $wpdb->insert(
            "{$wpdb->prefix}help_widget_answers",
            array(
                'ip' => $ip,
                'post_id' => $postID,
                'answer' => $answer,
                'comment' => $comment,
                'comment_type' => $commentType
            ),
            array(
                '%s',
                '%s',
                '%s',
                '%s'
            )
        );

        return $wpdb->insert_id;
    }

    /**
     * Updates a answer to add comment andcomment typ
     * @param integer $id          The answer id
     * @param string $comment      The comment
     * @param string $commentType  The comment type (chat or message)
     */
    public function addCommentToAnswer($id, $comment, $commentType) {
        global $wpdb;

        $wpdb->update(
            "{$wpdb->prefix}help_widget_answers",
            array(
                'comment' => $comment,
                'comment_type' => $commentType
            ),
            array('id' => $id),
            array(
                '%s', '%s'
            ),
            array(
                '%d'
            )
        );

        return true;
    }

    /**
     * Get all comments from a specific post id
     * @param  integer $postID Post id
     * @return array           The comments
     */
    public function getComments($postID)
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}help_widget_answers WHERE post_id = $postID AND answer = 'no' AND comment != '' ORDER BY created_at DESC");
    }

    /**
     * Counts answers based on postID and answer
     * @param  integer $postID The post id
     * @param  strin   $answer The answer to look for
     * @return integer         The answer count
     */
    public function countAnswers($postID, $answer)
    {
        global $wpdb;
        return $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}help_widget_answers WHERE answer = '{$answer}'");
    }

}