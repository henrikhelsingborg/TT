Helsingborg = Helsingborg || {};
Helsingborg.Prompt = Helsingborg.Search || {};

Helsingborg.Prompt.Modal = (function ($) {

    var fadeSpeed = 300;


    function Modal() {
        $(function(){

            this.handleEvents();

        }.bind(this));
    }

    Modal.prototype.open = function(element) {
        var targetElement = $(element).closest('[data-reveal]').data('reveal');
        $('#' + targetElement).fadeIn(fadeSpeed);
        this.disableBodyScroll();
    }

    Modal.prototype.close = function(element) {
        $(element).closest('.modal').fadeOut(fadeSpeed);
    }

    Modal.prototype.disableBodyScroll = function() {
        $('body').addClass('no-scroll');
    }

    Modal.prototype.enableBodyScroll = function() {
        $('body').removeClass('no-scroll');
    }

    /**
     * Keeps track of events
     * @return {void}
     */
    Modal.prototype.handleEvents = function() {

        // Open modal
        $(document).on('click', '[data-reveal]', function (e) {
            e.preventDefault();
            this.open(e.target);
        }.bind(this));

        // Close modal
        $(document).on('click', '[data-action="modal-close"]', function (e) {
            e.preventDefault();
            this.close(e.target);
        }.bind(this));

    }

    return new Modal();

})(jQuery);