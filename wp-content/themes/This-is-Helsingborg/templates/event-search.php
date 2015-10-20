<?php
/*
Template Name: Evenemang
*/

get_header();

$administration_unit_ids = (isset($_GET['q']) && strlen($_GET['q']) > 0) ? $_GET['q'] : 0;
?>

<script>
    var adminIDs = '<?php echo $administration_unit_ids; ?>';
    var defaultImagePath = '<?php echo get_template_directory_uri(); ?>/assets/images/event-placeholder.jpg';
</script>

<section class="section-featured section-featured-search creamy">
    <div class="container">
        <div class="row">
            <div class="columns large-12">
                <h2>Sök evenemang</h2>
                <form class="creamy-filter">
                    <div class="row">
                    <!-- ko foreach: filter.filters -->
                        <!-- ko if: (Type == 'select') -->
                        <div class="form-group columns medium-6 left">
                            <div>
                                <label class="form-label" data-bind="text: Name" for="municipality_multiselect"></label>
                                <select class="form-control" id="municipality_multiselect" data-bind="options: Options, optionsText: 'Name', optionsValue: 'ID', value='CurrentOption'"></select>
                            </div>
                        </div>
                        <!-- /ko -->

                        <!-- ko if: (Type == 'text') -->
                        <div class="form-group columns medium-6 left">
                            <label class="form-label" data-bind="text: Name, attr: { for: Name + 'input' }"></label>
                            <input class="form-control" type="text" data-bind="value: Value, valueUpdate: 'afterkeydown', attr: { id: Name + 'input' }">
                        </div>
                        <!-- /ko -->

                        <!-- ko if: (Type == 'calendar') -->
                        <div class="form-group columns medium-6 left">
                            <div class="input-column input-column-half">
                                <label class="form-label" data-bind="text: Name, attr: { for: CalendarID }"></label>
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
        </div>
    </div>
</section>

<section class="section-search-result">
    <div class="container">
        <div class="row">
            <div class="columns large-9 medium-9 small-12 print-12">
                <div class="row">
                    <div class="columns large-12">
                        <!-- ko if: pager.maxPageIndex() > 0 -->
                        <ul class="pagination" role="menubar" arial-label="pagination" style="display:block;">
                            <li><a href="#" data-bind="click: pager.movePrevious, enable: pager.currentPageIndex() > 0">&laquo; Föregående</a></li>

                            <!-- ko foreach: pager.pagerPages() -->
                            <li data-bind="css: $parent.pager.currentStatus($data-1), visible: $parent.pager.isHidden($index())">
                                <a href="#" data-bind="text: ($data), click: function(data, event) { $parent.pager.changePageIndex($data-1) }"></a>
                            </li>
                            <!-- /ko -->

                            <li><a href="#" data-bind="click: pager.moveNext, enable: pager.currentPageIndex() < pager.maxPageIndex()">Nästa &raquo;</a></li>
                        </ul>
                        <!-- /ko -->
                    </div>
                </div>

                <div class="row">
                    <div class="columns large-12">
                        <ul class="search-result" data-bind="template: {name:'eventTemplate', foreach: pager.currentPageEvents}"></ul>
                        <div id="events-loading-indicator">
                            <i class="hbg-loading">Läser in evenemang…</i>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="columns large-12">
                        <!-- ko if: pager.maxPageIndex() > 0 -->
                        <ul class="pagination" role="menubar" arial-label="pagination" style="display:block;">
                            <li><a href="#" data-bind="click: pager.movePrevious, enable: pager.currentPageIndex() > 0">&laquo; Föregående</a></li>

                            <!-- ko foreach: pager.pagerPages() -->
                            <li data-bind="css: $parent.pager.currentStatus($data-1), visible: $parent.pager.isHidden($index())">
                                <a href="#" data-bind="text: ($data), click: function(data, event) { $parent.pager.changePageIndex($data-1) }"></a>
                            </li>
                            <!-- /ko -->

                            <li><a href="#" data-bind="click: pager.moveNext, enable: pager.currentPageIndex() < pager.maxPageIndex()">Nästa &raquo;</a></li>
                        </ul>
                        <!-- /ko -->
                    </div>
                </div>
            </div>

            <?php
                if (is_active_sidebar('right-sidebar')) {
                    get_template_part('templates/partials/sidebar', 'right');
                }
            ?>
        </div>
    </div>
</section>

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
                <a href="#" class="link-item" data-bind="text: Name, attr: {id: EventID}" data-reveal="eventModal" id=""></a>
            </h3>
            <p data-bind="trimText: Description"></p>
        </div>
    </li>
</script>

<?php
    /**
     * Get the modal window markup
     */
    get_template_part('templates/partials/modal', 'event');
?>

<?php get_footer(); ?>