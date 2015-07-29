var Helsingborg;



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
    });

    /**
     * Search button click
     */
    $('.search .btn-submit').on('click', function (e) {
        if ($(this).parents('.hero').length) {
            $(this).html('<i class="dots-loading dots-loading-small"></i>');
        } else {
            $(this).html('<i class="dots-loading"></i>');
        }
    });

    /**
     * Table list
     */
    if ($('.table-list').length > 0) {
        $('.table-list').delegate('tbody tr.table-item','click', function(){
            if(!$(this).is('.active')) {
                $('.table-item').removeClass('active');
                $('.table-content').removeClass('open');
                $(this).addClass('active');
                $(this).next('.table-content').addClass('open');
            } else if($(this).hasClass('active')) {
                $(this).toggleClass('active');
                $(this).next('.table-content').removeClass('open');
            }
        });
    }

});