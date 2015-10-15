<?php

namespace Helsingborg\Theme;

class LazyLoad
{
    public function __construct()
    {
        add_filter('the_content', array($this, 'replaceImageTags'));
    }

    /**
     * Find image tags in content.
     *
     * @param string $content The content of the post
     *
     * @return string The new content of the post
     */
    public function replaceImageTags($content)
    {
        return preg_replace_callback(
            '/(<\s*img[^>]+)(src\s*=\s*"[^"]+")([^>]+>)/i',
            array($this, 'replaceImageTagsCallback'),
            $content
        );
    }

    /**
     * Do the actual replace of default image to lazyload images.
     *
     * @param array $matches Matching
     *
     * @return string The new image tag
     */
    public function replaceImageTagsCallback($matches)
    {
        // Get the img tag height
        preg_match_all('/height="(\d+)"/i', $matches[0], $imageHeight);
        $imageHeight = (isset($imageHeight[1][0])) ? $imageHeight[1][0] : 500;

        // Get the img tag width
        preg_match_all('/width="(\d+)"/i', $matches[0], $imageWidth);
        $imageWidth = (isset($imageWidth[1][0])) ? $imageWidth[1][0] : 500;

        // Placeholder url
        $placeholderSrc = 'http://placehold.it/'.$imageWidth.'x'.$imageHeight.'/F6F5F2/333333/?text=%20';

        $lazyImage = $matches[1].
                     ' src="'.get_stylesheet_directory_uri().'/assets/images/img-placeholder.png" data-lazyload'.
                     substr($matches[2], 3).'" '.$matches[3];

        return $lazyImage;
    }
}
