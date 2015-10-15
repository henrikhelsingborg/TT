<?php

namespace Helsingborg\Helper;

class Wp
{

    public function __construct()
    {
        add_filter('the_content', '\Helsingborg\Helper\Wp::removeEmptyP', 20, 1);
        add_filter('the_content', '\Helsingborg\Helper\Wp::wrapYoutube');
    }

    /**
     * Searches stylesheet directory and template directory for a specific template file and returns the path
     * @param  string  $prefix The file prefix
     * @param  string  $slug   The file name/slug
     * @param  boolean $error  Wheather to show errors or not
     * @return string          The located template file's path
     */
    public static function getTemplate($prefix = '', $slug = '', $error = true)
    {
        $paths = apply_filters('Helsingborg/TemplatePath', array(
            get_stylesheet_directory().'/templates/',
            get_template_directory().'/templates/',
            HELSINGBORG_PATH . '/templates/',
        ));

        $slug = apply_filters('Helsingborg/TemplatePathSlug', $slug ? '/'.$slug.'/' : '', $prefix);
        $prefix = $prefix ? '-'.$prefix : '';

        foreach ($paths as $path) {
            $file = $path.$slug.'helsingborg'.$prefix.'.php';
            if (file_exists($file)) {
                return $file;
            }
        }

        if ($error) {
            trigger_error(
                'Helsingborg: Template ' . $slug . 'helsingborg' . $prefix . '.php' .
                ' not found in any of the paths: ' . var_export($paths, true),
                E_USER_WARNING
            );
        }
    }

    /**
     * Gets site info
     * @return array The siteinfo
     */
    public static function getSiteInfo()
    {
        $siteInfo = array(
            'name' => get_bloginfo('name'),
            'url' => esc_url(home_url('/')),
        );

        return $siteInfo;
    }

    /**
     * Function for displaying proper IDs depending on current location, used by wp_include_pages for the menus.
     * @param  array $post The post
     * @return string      Post ids
     */
    public static function getIncludedPages($post)
    {
        $includes = array();
        $args = array(
            'post_type'   => 'page',
            'post_status' => 'publish',
            'post_parent' => get_option('page_on_front'),
        );

        $base_pages = get_children($args);
        foreach ($base_pages as $page) {
            array_push($includes, $page->ID);
        }

        if ($post) {
            $ancestors = get_post_ancestors($post);
            array_push($ancestors, strval($post->ID));

            foreach ($ancestors as $ancestor) {
                $args = array(
                    'post_type'   => 'page',
                    'post_status' => 'publish',
                    'post_parent' => $ancestor,
                );

                $childs = get_children($args);

                foreach ($childs as $child) {
                    array_push($includes, $child->ID);
                }

                array_push($includes, $ancestor);
            }
        }

        return implode(',', $includes);
    }

    /**
     * Removes empty <p> tags from the post content
     * @param  string $content The post content
     * @return string          Post content without empty <p>-tags
     */
    public static function removeEmptyP($content)
    {
        // clean up p tags around block elements
        $content = preg_replace(array(
            '#<p>\s*<(div|aside|section|article|header|footer)#',
            '#</(div|aside|section|article|header|footer)>\s*</p>#',
            '#</(div|aside|section|article|header|footer)>\s*<br ?/?>#',
            '#<(div|aside|section|article|header|footer)(.*?)>\s*</p>#',
            '#<p>\s*</(div|aside|section|article|header|footer)#',
            '#<p>(\s|&nbsp;)*+(<br\s*/*>)?(\s|&nbsp;)*</p>#'
        ), array(
            '<$1',
            '</$1>',
            '</$1>',
            '<$1$2>',
            '</$1',
        ), $content);

        return preg_replace('#<p>(\s|&nbsp;)*+(<br\s*/*>)*(\s|&nbsp;)*</p>#i', '', $content);
    }

    public static function getExcerptById($postId = 0)
    {
        global $post;

        $save_post = $post;
        $post = get_post($postId);
        setup_postdata($post);

        $excerpt = get_the_excerpt();
        $post = $save_post;
        wp_reset_postdata($post);

        return $excerpt;
    }

    /**
     * Wrap YouTube embeds in the content to make them responsive
     * @param  string $content The content before
     * @return string          The content after
     */
    public static function wrapYoutube($content)
    {
        $pattern = '~<iframe.*?</iframe>~';
        $content = preg_replace_callback($pattern, function ($matches) {
            if (stripos($matches[0], 'youtube') !== false) {
                return '<div class="flex-video widescreen">' . $matches[0] . '</div>';
            }

            return $matches[0];
        }, $content);

        return $content;
    }
}
