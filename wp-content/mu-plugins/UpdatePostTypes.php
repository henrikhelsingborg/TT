<?php

namespace UpdatePostTypes;

class UpdatePostTypes
{
    public $parent_page = "startsida";
    public $post_types = array();
    public $exclude = array(11525, 9115);

    public function __construct()
    {
        if (isset($_GET['change-post-types']) && $_GET['change-post-types'] === 'step-1') {
            add_action('init', array($this, 'stepOne'), 20);
        }

        if (isset($_GET['change-post-types']) && $_GET['change-post-types'] === 'step-2') {
            add_action('init', array($this, 'stepTwo'), 20);
        }
    }

    public function stepOne()
    {
        $this->savePostTypes();
        $this->addTaxonomy();
        $this->updatePosts();
        $this->end();
    }

    public function end()
    {
        echo "<pre>";
        print_r($this->post_types);
        exit;
    }

    public function addTaxonomy()
    {
        $taxonomies = array(array(
            'label'                => 'Kategorier',
            'slug'                 => 'kategorier',
            'hierarchical'         => true,
            'connected_post_types' => array('nyheter'),
            'public'               => true,
            'show_ui'              => true
        ));
        update_field('avabile_dynamic_taxonomies', $taxonomies, 'options');
    }

    public function updatePosts()
    {
        foreach ($this->post_types as $key => $post) {

            // Update all descendants post types
            $descendants = $this->getPostChildren($post['parent'], 'any', 'page');
            foreach ($descendants as $key => $descendant) {
                set_post_type($descendant->ID, $post['name']);
            }

            // Remove post parent from parents
            wp_update_post(
                array(
                    'ID' => $post['parent'],
                    'post_parent' => 0,
                )
            );
        }

        foreach ($this->exclude as $key => $post) {
            wp_update_post(
                array(
                    'ID' => $post,
                    'post_parent' => 0,
                )
            );
        }

        return true;
    }

    public function savePostTypes()
    {
        $parent = get_page_by_path($this->parent_page);
        if (!$parent) {
            $this->post_types['Error'] = "Parent not found";
            return false;
        }

        $args = array(
            'post_parent' => $parent->ID,
            'post_type'   => 'page',
            'numberposts' => -1,
            'post_status' => 'any',
            'exclude'     => $this->exclude,
        );
        $children = get_children($args);

        $new_post_types = array();
        $parent_pages = array();
        foreach ($children as $key => $child) {
            $hierarchical = true;
            if ($child->post_name == "nyhetskatalog") {
                $child->post_name = "nyheter";
                $child->post_title = "Nyheter";
                $hierarchical = false;
            }

            $parent_pages[] = array(
                'post_type_name' => $child->post_title,
                'slug' => $child->post_name,
                'with_front' => false,
                'menu_position' => 20,
                'public' => true,
                'exclude_from_search' => false,
                'show_in_nav_menus' => true,
                'hierarchical' => $hierarchical,
                'show_posts_in_sidebar_menu' => true,
                'supports' => array("editor","author","thumbnail","excerpt","trackbacks","comments","page-attributes","post-formats"),
            );
            update_field('avabile_dynamic_post_types', $parent_pages, 'options');

            $name = sanitize_title(substr($child->post_title, 0, 19));
            $new_post_types[] = array('name' => $name, 'parent' => $child->ID, 'title' => $child->post_title);
        }

        add_option('new_post_types_temp', $new_post_types, '', 'yes' );
        $this->post_types = $new_post_types;

        return true;
    }

    public function getPostChildren($parent_id, $post_status, $post_type)
    {
        $children = array();
        $posts = get_posts(array('numberposts' => -1, 'post_status' => $post_status, 'post_type' => $post_type, 'post_parent' => $parent_id, 'suppress_filters' => false));

        foreach ($posts as $child) {
            $gchildren = $this->getPostChildren($child->ID, $post_status, $post_type);
            if (!empty($gchildren)) {
                $children = array_merge($children, $gchildren);
            }
        }

        $children = array_merge($children, $posts);

        return $children;
    }

    // Step 2. Save taxonomies and News

    public function stepTwo()
    {
        $this->post_types = get_option('new_post_types_temp');
        $this->saveTaxonomies();
        $this->saveNews();
        delete_option('new_post_types_temp');
        $this->end();
    }

    public function saveTaxonomies()
    {
        foreach ($this->post_types as $post_type) {
            if ($post_type['title'] != "Nyheter") {
                $term = wp_insert_term($post_type['title'], 'kategorier');
            }
        }

        return true;
    }

    public function saveNews()
    {
        foreach ($this->post_types as $post_type) {
            $args = array(
                'post_parent' => $post_type['parent'],
                'post_type'   => $post_type['name'],
                'numberposts' => -1,
                'post_status' => 'any'
            );
            $children = get_children($args);

            foreach ($children as $child) {
                if ($child->post_type == "nyheter") {
                    wp_update_post(
                        array(
                            'ID' => $child->ID,
                            'post_parent' => 0,
                        )
                    );
                    wp_set_post_terms($child->ID, array("Okategoriserat"), 'kategorier');
                } elseif (preg_match('/Nyhet.*/i', $child->post_title)) {
                    $descendants = $this->getPostChildren($child->ID, 'any', 'any');
                    foreach ($descendants as $d) {
                        wp_update_post(
                            array(
                                'ID' => $d->ID,
                                'post_parent' => 0,
                                'post_type' => 'nyheter',
                            )
                        );
                        wp_set_post_terms($d->ID, array($post_type['title']), 'kategorier');
                    }
                    wp_update_post(
                        array(
                            'ID' => $child->ID,
                            'post_parent' => 0,
                            'post_type' => 'nyheter',
                        )
                    );
                    wp_set_post_terms($child->ID, array("Okategoriserat"), 'kategorier');
                } else {
                   // Remove first level childrens parents
                    wp_update_post(
                        array(
                            'ID' => $child->ID,
                            'post_parent' => 0,
                        )
                    );

                }
            }
        }
    }
}

new \UpdatePostTypes\UpdatePostTypes();
