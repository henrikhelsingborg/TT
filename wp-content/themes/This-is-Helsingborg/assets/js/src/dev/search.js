Helsingborg = Helsingborg || {};
Helsingborg.Search = Helsingborg.Search || {};

Helsingborg.Search.Autocomplete = (function ($) {

    function Autocomplete() {
        $(function(){

            this.handleEvents();

        }.bind(this));
    }

    Autocomplete.prototype.search = function(searchString, element) {
        if (searchString.length >= 3) {
            jQuery.post(
                ajaxurl,
                {
                    action: 'search_pages',
                    s: searchString
                },
                function(response) {
                    response = JSON.parse(response);

                    var autocomplete = $(element).siblings('ul.autocomplete');
                    autocomplete.empty();
                    autocomplete.append('<li class="heading">Utvalda resultat (klicka på "sök" för alla resultat):</li>');

                    $.each(response, function (index, item) {
                        autocomplete.append('<li>\
                            <a href="' + item.permalink + '">\
                                <strong class="link-item">' + item.page.post_title + '</strong>\
                                <p>' + item.excerpt + '</p>\
                            </a>\
                        </li>')
                    });

                    this.show(element);
                }.bind(this)
            );
        } else {
            this.hide(element);
        }
    }

    Autocomplete.prototype.hide = function(element) {
        $(element).siblings('ul.autocomplete').hide();
    }

    Autocomplete.prototype.show = function(element) {
        $(element).siblings('ul.autocomplete').show();
    }

    Autocomplete.prototype.arrowNext = function(element) {
        var autocomplete = $(element).siblings('ul.autocomplete');
        var selected = autocomplete.find('li.selected');

        if (selected.length) {
            var next = selected.next('li');
            selected.removeClass('selected');
            next.addClass('selected');
        } else {
            autocomplete.find('li:first-child').addClass('selected');
        }
    }

    Autocomplete.prototype.arrowPrev = function(element) {
        var autocomplete = $(element).siblings('ul.autocomplete');
        var selected = autocomplete.find('li.selected');

        if (selected.length) {
            var next = selected.prev('li');
            selected.removeClass('selected');
            next.addClass('selected');
        } else {
            autocomplete.find('li:last-child').addClass('selected');
        }
    }

    /**
     * Keeps track of events
     * @return {void}
     */
    Autocomplete.prototype.handleEvents = function() {

        $(document).on('input', '[data-autocomplete="pages"]', function (e) {
            var val = $(e.target).closest('input').val();
            this.search(val, e.target);
        }.bind(this));

        $(document).on('blur', '[data-autocomplete="pages"]', function (e) {
            this.hide(e.target);
        }.bind(this));

        $(document).on('focus', '[data-autocomplete="pages"]', function (e) {
            this.show(e.target);
        }.bind(this));

        $(document).on('keydown', function (e) {
            if ($(e.target).data('autocomplete')) {
                switch (e.which) {
                    case 38 : // Up
                        e.preventDefault();
                        this.arrowPrev(e.target);
                        break;

                    case 40 : // Down
                        e.preventDefault();
                        this.arrowNext(e.target);
                        break;

                    case 13 : // Enter/return
                        if ($(e.target).closest('input').siblings('ul.autocomplete').find('li.selected a').length) {
                            e.preventDefault();
                            location.href = $(e.target).closest('input').siblings('ul.autocomplete').find('li.selected a').attr('href');
                        } else {
                            return true;
                        }
                        break;
                }
            }
        }.bind(this));

    }

    return new Autocomplete();

})(jQuery);





Helsingborg.Search.Button = (function ($) {

    function Button() {
        $(function(){

            this.handleEvents();

        }.bind(this));
    }

    /**
     * Keeps track of events
     * @return {void}
     */
    Button.prototype.handleEvents = function() {

        $(document).on('click', '.search .btn-submit', function (e) {
            if ($(this).parents('.hero').length) {
                $(this).html('<i class="dots-loading dots-loading-small"></i>');
            } else {
                $(this).html('<i class="dots-loading"></i>');
            }
        });

    }

    return new Button();

})(jQuery);