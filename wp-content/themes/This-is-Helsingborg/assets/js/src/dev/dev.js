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
     * Get disturbances
     */
    jQuery.post(ajaxurl, { action: 'big_notification' }, function(response) {
        if (response) {
            response = JSON.parse(response);
            $.each(response, function (index, item) {
                var message = '<a href="' + item.link + '">' + item.title + '</a>';
                Helsingborg.Prompt.Alert.show(item.class, message);
            });
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

    if (typeof is_front_page !== 'undefined') {
        var mobile_menu_offset = $('.nav-mainmenu-container').offset().top;
        if ($('body').find('#wpadminbar').length) mobile_menu_offset = mobile_menu_offset - 32;

        $(window).on('scroll', function (e) {
            if ($(window).scrollTop() >= mobile_menu_offset) {
                $('.nav-mainmenu-container, body').addClass('nav-fixed');
                if ($('body').find('#wpadminbar').length) $('.nav-mainmenu-container.nav-fixed').css('top', '32px');
            } else {
                if ($('body').find('#wpadminbar').length) $('.nav-mainmenu-container.nav-fixed').css('top', '0');
                $('.nav-mainmenu-container, body').removeClass('nav-fixed');
            }
        });
    }

});