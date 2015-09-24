var Helsingborg;

// Gallery settings
var gallery_image_per_row = 2;
var gallery_use_masonry = false;

jQuery(document).ready(function ($) {

    /**
     * Initializes Foundation JS with necessary plugins:
     * Equalizer
     */
    $(document).foundation({
        equalizer: {
            equalize_on_stack: true
        },
        orbit: {
            slide_number_text: 'av'
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

    // Gallery open
    /*
    $('.hbg-gallery-item').on('click', function (e) {
        e.preventDefault();
        var $modal = $('#' + $(this).data('reveal'));

        if ($(this).data('image')) {
            $modal.find('.modal-media').html('<img class="reponsive" src="' + $(this).data('image') + '">');
        }

        if ($(this).data('youtube')) {
            var youtube_url = $(this).data('youtube');
            var pattern = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
            var youtube_id = (youtube_url.match(pattern)) ? RegExp.$1 : false;

            if (youtube_id) {
                $modal.find('.modal-media').html('\
                    <div class="flex-video widescreen">\
                        <iframe src="https://www.youtube.com/embed/' + youtube_id + '?autoplay=1" frameborder="0" allowfullscreen></iframe>\
                    </div>\
                ');
            }
        }

        $modal.find('.modal-text').html('<h3>' + $(this).data('title') + '</h3>' + $(this).data('description'));
    });

    $('[id^="gallery-modal-"] .modal-close').on('click', function (e) {
        $(this).closest('[id^="gallery-modal-"]').find('.modal-media').html('');
    });
    */
   
    $('.mobile-menu-wrapper').find('input, button').attr('tabindex', '-1');

    $('[data-tooltip*="click"]').on('click', function (e) {
        if ($(e.target).is('[data-tooltip-toggle]')) {
            e.preventDefault();
            $(this).find('.tooltip').toggle().find('textarea:first').focus();
        }
    });

});