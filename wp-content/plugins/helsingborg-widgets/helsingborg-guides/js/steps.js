jQuery(document).ready(function($) {

    $('.next-step').on('click', function(e) {
        e.preventDefault();

        var currentElem = $('.guide-list li.current');

        if (currentElem.next().length) {
            currentElem.next().addClass("current");
            currentElem.removeClass("current");
            setPager();
        }
    });

    $('.prev-step').on('click', function(e) {
        e.preventDefault();

        var currentElem = $('.guide-list li.current');

        if (currentElem.prev().length) {
            currentElem.prev().addClass("current");
            currentElem.removeClass("current");
            setPager();
        }
    });

    $('.pagination li a').on('click', function(e) {
        if ($(this).text().length <= 3 && $(this).text().length > 0) {
            e.preventDefault();

            var currentElem = $('.guide-list li.current');
            var newElem = $('.guide-list > li').not('.guide-list li ul li').eq(
                parseInt($(this).text()) - 1);

            currentElem.removeClass("current");
            newElem.addClass("current");
            setPager();
        }
    });

    function setPager() {
        var newIndex = $('.guide-list > li').not('.guide-list li ul li').index($(
            '.guide-list li.current'));

        $('.pagination li.current-pager').removeClass('current-pager');
        $('.pagination li').eq(newIndex + 1).addClass('current-pager');
    }

    function removeNext() {
        if ($('.guide-list li.current:last-child').length) {
            $('.next-step').hide();
        } else {
            $('.next-step').show();
        }

    }

    function removePrev() {
        if ($('.guide-list li.current:first-child').length) {
            $('.prev-step').hide();
        } else {
            $('.prev-step').show();
        }
    }

});
