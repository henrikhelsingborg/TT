<?php
/*
Template Name: Alarm
*/

get_header();
?>

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

<?php get_footer(); ?>