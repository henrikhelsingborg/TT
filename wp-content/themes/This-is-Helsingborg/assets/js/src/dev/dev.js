jQuery(document).ready(function ($) {

    /**
     * Initializes Foundation JS with necessary plugins:
     * Equalizer
     */
    $(document).foundation({
        equalizer: {
            equalize_on_stack: true
        }
    });

    /**
     * Modal window
     */
    $(document).on('click', '[data-reveal]', function (e) {
        e.preventDefault();
        var target = $(this).data('reveal');
        $('#' + target).fadeIn(300);
        $('body').addClass('no-scroll');
    })

    $(document).on('click', '[data-action="modal-close"]', function (e) {
        e.preventDefault();
        $(this).parents('.modal').fadeOut(300);
        $('body').removeClass('no-scroll');
    })

});