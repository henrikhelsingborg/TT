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
    var navHeight = $('.mobile-menu-wrapper').height();
    $('.mobile-menu-wrapper').css({
        maxHeight: 0,
        position: 'relative',
        zIndex: 1
    });
    $('.mobile-menu-wrapper .stripe').css('height', navHeight + 'px');

    $(document).on('click', '[data-action="toggle-mobile-menu"]', function (e) {
        e.preventDefault();
        var body = $('body');
        $(this).toggleClass('open');
        $('body').toggleClass('mobile-menu-in');

        if (body.hasClass('mobile-menu-in')) {
            $('.mobile-menu-wrapper').css('visibility', 'visible').animate({
                maxHeight: navHeight + 'px'
            }, 100);
        } else {
            $('.mobile-menu-wrapper').css('visibility', 'visible').animate({
                maxHeight: 0 + 'px'
            }, 100);
        }
    })

});