<?php
/*
Template Name: Evenemang
*/

get_header();

// Get all AdministrationUnitID -> so we can
$administration_unit_ids = $_GET['q'];
if(!$administration_unit_ids) { $administration_unit_ids = 0; }

// Get the content, see if <!--more--> is inserted
$the_content = get_extended($post->post_content);
$main = $the_content['main'];
$content = $the_content['extended']; // If content is empty, no <!--more--> tag was used -> content is in $main
?>



<div class="content-container event-list-page">
    <div class="row">
        <div class="main-content columns large-8 medium-12">
            <?php
            /**
             * Breadcrumb
             */
            if (!is_front_page()) {
                the_breadcrumb();
            }
            ?>
                <h1>Sök evenemang</h1>

                <div class="form-container">
                    <form class="list-form">
                        <div class="row">
                        <!-- ko foreach: filter.filters -->
                            <!-- ko if: (Type == 'select') -->
                            <div class="form-group columns medium-6 left">
                                <div>
                                    <label class="form-label" data-bind="text: Name"></label>
                                    <select class="form-control" id="municipality_multiselect" data-bind="options: Options, optionsText: 'Name', optionsValue: 'ID', value='CurrentOption'"></select>
                                </div>
                            </div>
                            <!-- /ko -->

                            <!-- ko if: (Type == 'text') -->
                            <div class="form-group columns medium-6 left">
                                <label class="form-label" data-bind="text: Name"></label>
                                <input class="form-control" type="text" data-bind="value: Value, valueUpdate: 'afterkeydown'">
                            </div>
                            <!-- /ko -->

                            <!-- ko if: (Type == 'calendar') -->
                            <div class="form-group columns medium-6 left">
                                <div class="input-column input-column-half">
                                    <label class="form-label" data-bind="text: Name"></label>
                                    <input class="form-control" type="text" data-bind="value: Value, valueUpdate: 'afterkeydown', attr: {id: CalendarID}">
                                </div>
                            </div>
                            <!-- /ko -->
                        <!-- /ko -->
                        </div>

                        <div class="form-group clearfix">
                            <label>
                                <input class="form-control" type="checkbox" onclick="updateEvents(this)">
                                Visa alla Helsingborgs evenemang
                            </label>
                        </div>

                        <input type="text" id="selectedTypes" style="display: none;" data-bind="textInput: selectedEventTypes"/>
                    </form>
                </div>

                <div class="list-container">
                    <div class="Pager" id="event-pager-top">
                        <!-- ko if: pager.maxPageIndex() > 0 -->
                        <ul class="pagination" role="menubar" aria-label="Pagination">
                            <li class="arrow"><a href="#" data-bind="click: pager.movePrevious, enable: pager.currentPageIndex() > 0">&laquo; Föregående</a></li>

                            <!-- ko foreach: pager.pagerPages() -->
                            <li data-bind="css: $parent.pager.currentStatus($data-1), visible: $parent.pager.isHidden($index())">
                                <a href="#" data-bind="text: ($data), click: function(data, event) { $parent.pager.changePageIndex($data-1) }"></a>
                            </li>
                            <!-- /ko -->

                            <li class="arrow"><a href="#" data-bind="click: pager.moveNext, enable: pager.currentPageIndex() < pager.maxPageIndex()">Nästa &raquo;</a></li>
                        </ul>
                        <!-- /ko -->
                    </div>

                    <div class="event-list-loader" id="loading-event" style="margin-top:10px;position:relative;"></div>
                    <div class="NoEvents" id="no-event"></div>

                    <ul data-bind="template: {name:'eventTemplate',foreach: pager.currentPageEvents}" class="event-list list"></ul>

                    <div class="Pager" id="event-pager-bottom">
                        <!-- ko if: pager.maxPageIndex() > 0 -->
                        <ul class="pagination" role="menubar" aria-label="Pagination">
                            <li class="arrow"><a href="#" data-bind="click: pager.movePrevious, enable: pager.currentPageIndex() > 0">&laquo; Föregående</a></li>

                            <!-- ko foreach: pager.pagerPages() -->
                            <li data-bind="css: $parent.pager.currentStatus($data-1), visible: $parent.pager.isHidden($index())">
                                <a href="#" data-bind="text: ($data), click: function(data, event) { $parent.pager.changePageIndex($data-1) }"></a>
                            </li>
                            <!-- /ko -->

                            <li class="arrow"><a href="#" data-bind="click: pager.moveNext, enable: pager.currentPageIndex() < pager.maxPageIndex()">Nästa &raquo;</a></li>
                        </ul>
                        <!-- /ko -->
                    </div>

                    <!-- MODAL TEMPLATE -->
                    <div id="eventModal" class="reveal-modal modal" data-reveal>
                        <img class="modal-image"/>

                        <div class="row">
                            <div class="modal-event-info large-12 columns">
                            <h2 class="modal-title"></h2>
                            <p class="modal-description"></p>
                            <p class="modal-link-url"></p>
                            <!--<p class="modal-date"></p>-->
                            </div>
                        </div>

                        <!-- IF arrangör exist -->
                        <div class="row">
                            <div class="large-6 columns" id="event-times">
                                <h2 class="section-title">Datum, tid och plats</h2>

                                <div class="divider fade">
                                    <div class="upper-divider"></div>
                                    <div class="lower-divider"></div>
                                </div>

                                <ul class="modal-list" id="time-modal"></ul>
                            </div>

                            <div class="large-6 columns" id="event-organizers">
                                <h2 class="section-title">Arrangör</h2>

                                <div class="divider fade">
                                    <div class="upper-divider"></div>
                                    <div class="lower-divider"></div>
                                </div>

                                <ul class="modal-list" id="organizer-modal"></ul>
                            </div>
                        </div>

                        <a class="close-reveal-modal">&#215;</a>
                    </div>
                    <!-- END MODAL -->

                    <script type="text/html" id="eventTemplate">
                        <li class="search-result-item row">
                            <div class="columns large-2 medium-2 small-12">
                                <!-- ko if: ImagePath -->
                                <img data-bind="attr: {src: ImagePath}" alt="{{ Name }}" data-bind="attr: { alt: Name }" class="responsive">
                                <!-- /ko -->

                                <!-- ko if: ImagePath == null -->
                                <img src="<?php echo get_template_directory_uri() ; ?>/assets/images/event-placeholder.jpg" data-bind="attr: { alt: Name }" class="responsive">
                                <!-- /ko -->
                            </div>

                            <div class="search-result-item-content columns large-10 medium-10 small-12">
                                <h3>
                                    <span class="search-result-item-date" data-bind="text: Date"></span>
                                    <a href="#" class="modal-link" data-bind="text: Name, attr: {id: EventID}" data-reveal-id="eventModal" id=""></a>
                                </h3>
                                <p data-bind="trimText: Description"></p>
                            </div>
                        </li>
                    </script>

                    <script type="text/javascript">
                        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                        var adminIDs = '<?php echo $administration_unit_ids; ?>';
                    </script>
                    <script src="<?php echo get_template_directory_uri() ; ?>/js/event-list-page.js"></script>
            </div>
        </div>

        <?php
            /**
             * Include sidebar here if welcome text does not exist
             * - If it's exists sidebar will be included in templates/partials/header-welcome.php instead
             */
            global $has_welcome_text;
            if ($has_welcome_text) echo '<div class="hide-for-large-up">';
            get_template_part('templates/partials/sidebar', 'right');
            if ($has_welcome_text) echo '</div>';
        ?>
    </div>


    <?php
        /**
         * Widget content-area
         */
        if ((is_active_sidebar('content-area') == true)) {
            echo '<aside class="content-area widgets-test-color clearfix">';
            dynamic_sidebar("content-area");
            echo '</aside>';
        }
    ?>
</div>

<?php get_footer(); ?>
