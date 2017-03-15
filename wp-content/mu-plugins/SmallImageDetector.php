<?php

namespace SmallImageDetector;

class SmallImageDetector
{
    public $result = array(
        'not_found' => array(),
        'small' => array(),
        'error' => array()
    );

    public function __construct()
    {
        add_action('init', array($this, 'start'));
    }

    public function start()
    {
        $images = $this->getImages(0, -1);

        foreach ($images as $image) {
            $this->checkImage($image);
        }

        $this->end();
    }

    public function end()
    {
        echo sprintf('%d images to small<br><br>', count($this->result['small']));

        foreach ($this->result['small'] as $image) {
            echo sprintf('[&nbsp;&nbsp;&nbsp;] %s<br>', $image['path']);
        }

        exit;
    }

    public function checkImage(\WP_Post $image) : bool
    {
        $meta = wp_get_attachment_metadata($image->ID);

        if (!isset($meta['file'])) {
            $this->result['error'][] = array('post' => $image, 'path' => '');
            return false;
        }

        $path = wp_upload_dir()['basedir'] . '/' . $meta['file'];
        $url = wp_get_attachment_url($image->ID);

        if (!file_exists($path)) {
            $this->result['not_found'][] = array('post' => $image, 'path' => $path);
            return false;
        }

        if (!isset($meta['width'])) {
            $this->result['error'][] = array('post' => $image, 'path' => $path);
            return false;
        }

        if ($meta['width'] < 1000) {
            $this->result['small'][] = array('post' => $image, 'path' => $path);
            $this->waterstamp($path);
            $this->removeThumbnails($path, $meta);
        }

        return true;
    }

    /**
     * Get images to check
     * @param  integer $offset
     * @param  integer $limit
     * @return array
     */
    public function getImages($offset = 0, $limit = 100) : array
    {
        $query = new \WP_Query(array(
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'post_status' => array('inherit', 'publish'),
            'posts_per_page' => $limit,
            'offset' => $offset
        ));

        // Remove svg images from array
        $images = array_filter($query->posts, function ($image) {
            return strpos($image->guid, '.svg') === false;
        });

        return $images;
    }

    /**
     * Adds waterstamp to image
     * @param  string $path
     * @return bool
     */
    public function waterstamp(string $path) : bool
    {
        if (mime_content_type($path) !== 'image/jpeg') {
            return false;
        }

        $image = imagecreatefromjpeg($path);

        // First circle
        imagefilledellipse($image, 12, 12, 10, 10, imagecolorallocate($image, 0, 0, 0));
        imagefilledellipse($image, 12, 12, 6, 6, imagecolorallocate($image, 255, 255, 255));

        imagejpeg($image, $path, 100);
        return true;
    }

    public function removeThumbnails(string $path, array $meta) : bool
    {
        $path = str_replace(basename($path), '', $path);
        $sizes = $meta['sizes'];

        foreach ($sizes as $size) {
            if (!file_exists($path . $size['file'])) {
                continue;
            }

            unlink($path . $size['file']);
        }

        return true;
    }
}

if (isset($_GET['small-image-detector']) && $_GET['small-image-detector'] === 'true') {
    new \SmallImageDetector\SmallImageDetector();
}
