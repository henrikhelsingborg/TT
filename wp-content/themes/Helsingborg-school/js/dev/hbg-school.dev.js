jQuery(document).ready(function ($) {

    $(document).foundation();

    $('#start-jr').on('click', function() {
      $(document).foundation('joyride','start');
    });

    /**
     * Opens the search form from the desktop main menu
     */
    $('.item-search a').on('click', function (e) {
        e.preventDefault;
        $(this).parent('.item-search').toggleClass('show-search');
    });

    $('.show-mobile-nav').bind('click', function(){
        $(this).toggleClass('active');
        console.log("Yepp");
    });

    $(window).on('resize', function () {
        var $offcanvas = $('.off-canvas-wrap');
        var $mobilemenubutton = $('.show-mobile-nav');
        if ($(window).width() > 640 && $offcanvas.hasClass('move-right')) {
            $offcanvas.removeClass('move-right');
            $mobilemenubutton.removeClass('active');
        }

        if ($(window).width() <= 640 && !$('.support-nav-mobile #google-translate-element').length) {
            $('#google-translate-element').detach().appendTo('.support-nav-mobile');
        } else if ($(window).width() > 640 && $('.support-nav-mobile #google-translate-element').length) {
            $('#google-translate-element').detach().insertAfter('.google-translate-toggle');
        }
    });

    $('.exit-off-canvas').bind('click', function(){
        if($('.show-mobile-nav').hasClass('active')) {
            $('.show-mobile-nav').removeClass('active');
        }
    });

    $('.show-mobile-search').bind('click', function(e){
        $('.mobile-search').toggle();
        e.preventDefault();
        $(this).toggleClass('active');
    });

    /**
     * Open close list tables
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