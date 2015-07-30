Helsingborg = Helsingborg || {};
Helsingborg.Search = Helsingborg.Search || {};

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