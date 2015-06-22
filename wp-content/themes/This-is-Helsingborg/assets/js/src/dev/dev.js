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

    /**
     * Mobile menu
     */
    var navHeight = $('.off-canvas').height();
    $('.off-canvas').css({
        maxHeight: 0,
        position: 'relative'
    });

    $(document).on('click', '[data-action="toggle-mobile-menu"]', function (e) {
        e.preventDefault();
        var body = $('body');
        $('body').toggleClass('off-canvas-in');

        if (body.hasClass('off-canvas-in')) {
            $('.off-canvas').css('visibility', 'visible').animate({
                maxHeight: navHeight + 'px'
            }, 300);
        } else {
            $('.off-canvas').css('visibility', 'visible').animate({
                maxHeight: 0 + 'px'
            }, 300);
        }
    })

});