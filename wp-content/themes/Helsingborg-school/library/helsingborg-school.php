<?php

    function extractSvg($symbol, $classes = '')
    {
        $symbol = file_get_contents($symbol);

        //Get by dom method
        if (class_exists('DOMDocument')) {
            $doc = new \DOMDocument();
            if ($doc->loadXML($symbol) === true) {
                try {
                    $doc->getElementsByTagName('svg');

                    $svg = $doc->getElementsByTagName('svg');
                    if ($svg->item(0)->C14N() !== null) {
                        $symbol = $svg->item(0)->C14N();
                    }
                } catch (exception $e) {
                    error_log("Error loading SVG file to header or footer.");
                }
            }
        }

        //Filter tags & comments (if above not applicated)
        $symbol = preg_replace('/<\?xml.*?\/>/im', '', $symbol); //Remove XML
        $symbol = preg_replace('/<!--(.*)-->/Uis', '', $symbol); //Remove comments & javascript

        if (strlen($classes) > 0) {
            $symbol = str_replace('<svg', '<svg class="' . $classes . '"', $symbol);
        }

        return $symbol;
    }

    /**
     * Checks if a given widget exists within a given sidebar
     * @param  string  $sidebarSlug  The slug of the sidebar to check in
     * @param  string  $widgetSearch The widget id to search for
     * @return boolean               Returns the widget instance or if nothing found return false
     */
    function has_welcome_text_widget() {
        global $post;
        $result = false;

        // Whete to look and what to look for
        $sidebarSlug = 'slider-area';
        $widgetSearch = 'text-';

        // Get all textwidgets on this page
        $widgetSlug = 'widget_' . $post->ID . '_text';
        $textWidgets = get_option($widgetSlug);

        // Get widgets that's inside the given sidebar
        $sidebars = wp_get_sidebars_widgets();
        $widgets = $sidebars[$sidebarSlug];

        // If there's no widgets inside the given sidebar return false
        if (count($widgets) == 0) return false;


        // Loop the widgets to find a match
        foreach ($widgets as $widget) {
            if (strpos($widget, $widgetSearch) > -1) {
                $result = $widget;
                break;
            }
        }

        $widgetIndex = preg_replace('/[^0-9.]+/', '', $result);
        $result = $textWidgets[$widgetIndex];

        return $result;
    }

    /**
     * Remove unwanted parent theme templates
     * @param  array $templates Loaded templates
     * @return array            New list of templates
     */
    function hbg_remove_page_templates($templates) {
        $to_disable = array(
            'templates/alarm-list-page.php',
            'templates/alarm-page.php',
            'templates/alarm-rss.php',
            'templates/start-page.php'
        );

        foreach($to_disable as $disable) {
            unset($templates[$disable]);
        }

        return $templates;
    }
    add_filter('theme_page_templates', 'hbg_remove_page_templates');

    function hbgWrapYoutube($content) {
        $pattern = '~<iframe.*?</iframe>~';
        $content = preg_replace_callback($pattern, function ($matches) {
            if (strpos($matches[0], 'youtube') !== false) {
                return '<div class="flex-video widescreen">' . $matches[0] . '</div>';
            }

            return $matches[0];
        }, $content);

        return $content;
    }
    add_filter('the_content', 'hbgWrapYoutube');

    function html5_insert_image($html, $id, $caption, $title, $align, $url, $size, $alt ) {
      //Always return an image with a <figure> tag, regardless of link or caption

      //Grab the image tag
      $image_tag = get_image_tag($id, '', $title, $align, $size);

      //Let's see if this contains a link
      $linkptrn = "/<a[^>]*>/";
      $found = preg_match($linkptrn, $html, $a_elem);

      // If no link, do nothing
      if($found > 0) {
        $a_elem = $a_elem[0];

        if(strstr($a_elem, "class=\"") !== false){ // If link already has class defined inject it to attribute
            $a_elem = str_replace("class=\"", "class=\"colorbox ", $a_elem);
        } else { // If no class defined, just add class attribute
            $a_elem = str_replace("<a ", "<a class=\"colorbox\" ", $a_elem);
        }
      } else {
        $a_elem = "";
      }
      // Set up the attributes for the caption <figure>
      $attributes  = (!empty($id) ? ' id="attachment_' . esc_attr($id) . '"' : '' );
      $attributes .= ' class="thumbnail wp-caption ' . 'align'.esc_attr($align) . '"';
      $output  = '<figure' . $attributes .'>';
      //add the image back in
      $output .= $a_elem;
      $output .= $image_tag;
      if($a_elem != "") {
        $output .= '</a>';
      }

      if ($caption) {
        $output .= '<figcaption class="caption wp-caption-text">'.$caption.'</figcaption>';
      }
      $output .= '</figure>';
      return $output;
    }
    add_filter('image_send_to_editor', 'html5_insert_image', 10, 9);
