<?php

namespace Helsingborg\Theme;

class ListPage {

    public $pageId = 0;

    public $headers = array();
    public $headerKeys = array();
    public $fields = null;

    /**
     * Set the page id
     * @param integer $id The id to set
     */
    public function setPageId($id)
    {
        $this->pageId = $id;
        $this->getListHeaders();
    }

    /**
     * Get list headline strings array
     * @return array
     */
    public function getListArray()
    {
        include_once(get_template_directory() . '/meta_boxes/UI/list-array.php');
        return $list;
    }

    /**
     * Gets the list headers
     * @return void
     */
    public function getListHeaders()
    {
        include_once(get_template_directory() . '/meta_boxes/UI/list-array.php');
        $meta = get_post_meta($this->pageId, '_helsingborg_meta', true);

        if (is_array($meta)) {
            $selectedListOptionsMeta = $meta['list_options'];
            $selectedListOptions = explode(',', $selectedListOptionsMeta);

            foreach ($selectedListOptions as $option) {
                array_push($this->headerKeys, $option);
                array_push($this->headers, $list[$option]);
            }
        }
    }

    public function getList()
    {
        $pages = get_pages(array(
            'sort_order'  => 'DESC',
            'sort_column' => 'post_modified',
            'child_of'    => $this->pageId,
            'post_type'   => 'page',
            'post_status' => 'publish'
        ));

        $listItems = array();

        foreach ($pages as $page) {
            $item = array();
            $index = 0;

            foreach ($this->headerKeys as $key) {
                $data = null;

                $child_meta = get_post_meta($page->ID,'_helsingborg_meta',TRUE);

                if (is_array($child_meta)) {
                    $data = $child_meta['article_options_' . $key];
                }

                // We dont want empty data, show "-" instead !
                if (empty($data)) $data = " - ";

                $arr = array(
                    strval('item' . $index) => $data
                );

                $item = array_merge($item, $arr);
                $index++;
            }

            // Build the content and add as array item
            $content = '<h2>' . esc_attr($page->post_title) . '</h2>
                        <div class="td-content">
                        <p>' . apply_filters('the_content', $page->post_content) . '</p>
                        </div>
                        <span class="icon"></span>';

            $itemContent = array('content' => $content);
            $item = array_merge($item, $itemContent);

            array_push($listItems, $item);
        }

        usort($listItems, function ($a, $b) {
            return strcmp($a["item0"], $b["item0"]);
        });

        return $listItems;
    }

}