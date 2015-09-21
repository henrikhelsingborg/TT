Helsingborg = Helsingborg || {};
Helsingborg.Prompt = Helsingborg.Prompt || {};

Helsingborg.Prompt.Modal = (function ($) {

    var fadeSpeed = 300;

    function Modal() {
        $(function(){

            this.handleEvents();

        }.bind(this));
    }

    /**
     * Opens a modal window
     * @param  {object} element Link item clicked
     * @return {void}
     */
    Modal.prototype.open = function(element) {
        var targetElement = $(element).closest('[data-reveal]').data('reveal');
        $('#' + targetElement).fadeIn(fadeSpeed);
        this.disableBodyScroll();
    }

    /**
     * Closes a modal window
     * @param  {object} element Link item clicked
     * @return {void}
     */
    Modal.prototype.close = function(element) {
        $(element).closest('.modal').fadeOut(fadeSpeed);
        this.enableBodyScroll();
    }

    /**
     * Disables scroll on body
     * @return {void}
     */
    Modal.prototype.disableBodyScroll = function() {
        $('body').addClass('no-scroll');
    }

    /**
     * Enables scroll on body
     * @return {void}
     */
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