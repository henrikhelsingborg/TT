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
    $('[data-reveal]').on('click', function (e) {
        e.preventDefault();
        var target = $(this).data('reveal');
        $('#' + target).fadeIn(300);
        $('body').addClass('no-scroll');
    })

    $('[data-action="modal-close"]').on('click', function (e) {
        e.preventDefault();
        $(this).parents('.modal').fadeOut(300);
        $('body').removeClass('no-scroll');
    })

});