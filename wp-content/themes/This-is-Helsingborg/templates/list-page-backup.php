<?php

    get_header();

    $centerClasses = 'large-6 medium-6 small-12';
    if (!is_active_sidebar('right-sidebar')) {
        $centerClasses = 'large-9 medium-9 small-12';
    }

    /**
     * Include list categories array
     */
    include_once(get_template_directory() . '/meta_boxes/UI/list-array.php');

    /**
     * Get the list headers
     */
    $headers = array();
    $headerKeys = array();
    $fields = get_fields($post->ID);

    /**
     * Get the list options for this page and create array with the values which we can use later on
     */
    $meta = get_post_meta($post->ID, '_helsingborg_meta', true);
    $selectedListOptionsMeta = array();
    $selectedListOptions = array();

    /**
     * Check if page has any data
     */
    if (is_array($meta)) {
        $selectedListOptionsMeta = $meta['list_options'];
        $selectedListOptions = explode(',', $selectedListOptionsMeta);
    }

    /**
     * Prepare the list and headers
     */
    foreach ($selectedListOptions as $option) {
        array_push($headerKeys, $option);
        array_push($headers, $list[$option]);
    }

    /**
     * Get child pages
     */
    $pages = get_pages(array(
        'sort_order'  => 'DESC',
        'sort_column' => 'post_modified',
        'child_of'    => $post->ID,
        'post_type'   => 'page',
        'post_status' => 'publish'
    ));

    $listItems = array();

    foreach ($pages as $page) {
        $item = array();
        $index = 0;

        foreach ($headerKeys as $key) {
            $data = null;

            $child_meta = get_post_meta($page->ID, '_helsingborg_meta', true);

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

    $jsonItems = json_encode($listItems);

?>

<section class="section-article">
    <div class="container">
        <div class="row">
            <div class="columns large-12">
                <?php the_breadcrumb(); ?>
            </div>
        </div>

        <div class="row">
            <?php get_template_part('templates/partials/sidebar', 'left'); ?>

            <div class="columns <?php echo $centerClasses; ?>">
                <?php get_template_part('templates/partials/article'); ?>

                <table class="table-list">
                    <thead>
                        <tr>
                            <th></th>
                            <?php
                                $int = 0;

                                foreach ($headers as $header) {
                                    $int++;
                                    echo('<th class="header" data-bind="click: sort">' . $header . '</th>');
                                }
                            ?>
                        </tr>
                    </thead>

                    <!-- ko foreach: { data: itemstoshow } -->
                    <tbody>
                        <tr class="table-item">
                            <?php
                                foreach ($headerKeys as $key => $value) {
                                    echo('<td data-bind="text: item' . strval($key) . '"></td>');
                                }
                            ?>
                        </tr>
                        <tr class="table-content">
                            <td colspan="<?php echo count($headers); ?>"><article class="article"><div class="article-body" data-bind="html: content"></div></article></td>
                        </tr>
                    </tbody>
                    <!-- /ko -->
                </table>

                <script type="text/javascript" language="javascript">
                    function ListViewModel() {
                        var self = this;
                        var itemjson = <?php echo $jsonItems; ?>;

                        /**
                        * Observables
                        */
                        self.itemjson = ko.observable(itemjson);
                        self.query = ko.observable('');
                        self.sortBy = ko.observable('');

                        /**
                        * Items to show
                        */
                        self.itemstoshow = ko.computed(function () {
                            // Search filter items
                            var sort = self.sortBy();
                            var search = self.query().toLowerCase();

                            var items = ko.utils.arrayFilter(self.itemjson(), function(item) {
                                return ((item.content.toLowerCase().indexOf(search) >= 0)
                                    <?php
                                        if (count($headerKeys) > 0) {
                                            echo '||';
                                        }

                                        foreach ($headerKeys as $key => $value) {
                                            echo '(item.item' . strval($key) . '.toLowerCase().indexOf(search) >= 0)';

                                            if ($key != (count($headerKeys) - 1)) {
                                                echo ' || ';
                                            }
                                        }
                                    ?>
                                );
                            });

                            return items;
                        }, self);

                        /**
                        * Triggering the sorting by click on column headers
                        */
                        self.sort = function (item, event) {
                            var el = $(event.target);
                            var thead = el.parents('table').find('thead');

                            if (el.hasClass('sorting-desc') || (!el.hasClass('sorting-desc') && !el.hasClass('sorting-asc'))) {
                                // Sort asc
                                self.resetSort(thead);
                                el.addClass('sorting-asc headerSortDown');
                                self.sortList('asc', el);
                            } else {
                                // Sort desc
                                self.resetSort(thead);
                                el.addClass('sorting-desc headerSortUp');
                                self.sortList('desc', el);
                            }
                        }

                        /**
                        * Do the actual sorting
                        */
                        self.sortList = function(order, el) {
                            var columnNum = (el.index() - 1);

                            if (order.toLowerCase() == 'asc') {
                                // Sort asc
                                self.itemjson().sort(function (a, b) {
                                    var a = a['item' + columnNum].toLowerCase();
                                    var b = b['item' + columnNum].toLowerCase();

                                    if (a < b) {
                                        return -1;
                                    }
                                    else if (a > b) {
                                        return 1;
                                    }
                                    else {
                                        return 0;
                                    }
                                });
                            } else if (order.toLowerCase() == 'desc') {
                                // Sort desc
                                self.itemjson().sort(function (a, b) {
                                    var a = a['item' + columnNum].toLowerCase();
                                    var b = b['item' + columnNum].toLowerCase();

                                    if (a > b) {
                                        return -1;
                                    }
                                    else if (a < b) {
                                        return 1;
                                    }
                                    else {
                                        return 0;
                                    }
                                });
                            }

                            self.sortBy(columnNum + order);
                        }

                        /**
                        * Reset the sorting classes on the table header
                        */
                        self.resetSort = function(thead) {
                            thead.find('th').removeClass('sorting-asc sorting-desc headerSortDown headerSortUp');
                        }
                    }

                    ko.applyBindings(new ListViewModel());
                </script>

                <?php if (is_active_sidebar('content-area')) : ?>
                <div class="widget-area" id="widget-content-area">
                    <?php dynamic_sidebar("content-area"); ?>
                </div>
                <?php endif; ?>
            </div>

            <?php
                if (is_active_sidebar('right-sidebar')) {
                    get_template_part('templates/partials/sidebar', 'right');
                }
            ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>