<?php
/*
Template Name: Alarm-sök
*/

get_header(); ?>

<section class="section-featured section-featured-search creamy">
    <div class="container">
        <div class="row">
            <div class="columns large-12">
                <h2>Sök alarm</h2>
                <form class="creamy-filter">
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
                </form>
            </div>
        </div>
    </div>
</section>

<section class="section-search-result">
    <div class="container">
        <div class="row">
            <div class="columns large-6 medium-6 small-12 print-12">
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
                        <ul class="search-result" data-bind="template: {name:'alarmTemplate', foreach: pager.currentPageEvents}"></ul>
                        <div id="events-loading-indicator">
                            <i class="hbg-loading">Läser in alarm…</i>
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

<?php
    /**
     * Get the modal window markup
     */
    get_template_part('templates/partials/modal', 'alarm');
?>

<script type="text/html" id="alarmTemplate">
    <li class="search-result-item">
        <ul class="label-list">
            <li>
                <span class="item-label">Datum och tid</span>
                <span class="item-value" data-bind="text: SentTime">2014-12-11 08:15</span>
            </li>
            <li>
                <span class="item-label">H&auml;ndelse</span>
                <a class="item-value modal-link" title="link-title" data-bind="attr: {id: IDnr}, text: HtText" data-reveal="alarmModal" desc="link-desc">Trafikolycka - singel Personbil Övrigt</a>
            </li>
            <li>
                <span class="item-label">Adress</span>
                <span class="item-value" title="link-title" data-bind="text: Address">Djurhagsvägen</span>
            </li>
            <li>
                <span class="item-label">Station</span>
                <span class="item-value" title="link-title" data-bind="text: Station">Bårslöv</span>
            </li>
            <li>
                <span class="item-label">Kommun</span>
                <span class="item-value" title="link-title" data-bind="text: Place">M85T</span>
            </li>
        </ul>
    </li>
</script>

<?php get_footer(); ?>