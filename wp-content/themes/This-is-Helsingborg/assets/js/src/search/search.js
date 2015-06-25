jQuery(document).ready(function ($) {

    var searchRequestData = {
        action:     'search',
        keyword:    query,
        index:      '1'
    };

    var nextData = null;
    var prevData = null;

    $.post(ajaxurl, searchRequestData, function(response) {
        presnetSearchResult(JSON.parse(response));
    });

    function presnetSearchResult(data) {

        var $resultContainer = $('.search-result');
        $resultContainer.empty();

        /**
         * Get next and prev an request
         * @type {Function}
         */
        var next     = data.queries.nextPage       !== undefined ? data.queries.nextPage[0]       : undefined;
        var prev     = data.queries.previousPage   !== undefined ? data.queries.previousPage[0]   : undefined;
        var request  = data.queries.request        !== undefined ? data.queries.request[0]        : undefined;

        /**
         * Get and set the number of hits text
         * @type {String}
         */
        var searchHitsInfo    = '<span class="search-hits">' + data.searchInformation.formattedTotalResults + '</span> träffar på <span class="search-query">' + data.queries.request[0].searchTerms + '</span> inom Helsingborg.se';
        $('.search-hits-info').html(searchHitsInfo);

        $.each(data.items, function (index, item) {
            /* Create the dom element */
            var $item = $('<li class="search-result-item"><div class="search-result-item-content"></div></li>');

            /* Store meta values in a variable */
            var meta = item.pagemap.metatags[0];

            /* Get a date */
            var dateMod = null;
            if (meta.moddate !== undefined) {
                dateMod = convertDate(meta.moddate);
            } else if (meta.pubdate !== undefined) {
                dateMod = convertDate(meta.pubdate);
            }

            /* Create dom for information */
            if (item.fileFormat == 'PDF/Adobe Acrobat') {
                $item.find('.search-result-item-content').append('<h3><a href="' + item.link + '" class="pdf-item">' + item.htmlTitle + '</a></h3>');
            } else {
                $item.find('.search-result-item-content').append('<h3><a href="' + item.link + '" class="link-item">' + item.htmlTitle + '</a></h3>');
            }

            $item.find('.search-result-item-content').append('<p>' + $.trim(item.htmlSnippet) + '</p>');
            $item.find('.search-result-item-content').append('<div class="search-result-item-info"></div>');
            $item.find('.search-result-item-info').append('<span class="search-result-item-url"><i class="fa fa-globe"></i> <a href="' + item.link + '">' + item.htmlFormattedUrl + '</a></span>');
            $item.find('h3').append('<span class="search-result-item-date"><i class="fa fa-clock-o"></i> ' + dateMod + '</span>');


            /* Append the item to the result container */
            $resultContainer.append($item);
        });
    }

    function convertDate(value) {
        if (value.length > 20) {
            var year = value.substring(2,6);
            var month = value.substring(6,8);
            var day = value.substring(8,10);
            month = convertDateToMonth(month);
            return day + ' ' + month + ' ' + year;
        } else if (value.length == 11) {
            value = value.replace('May', 'Maj');
            value = value.replace('Oct', 'Okt');
            return value;
        } else if (value.length == 8) {
            var year = value.substring(0,4);
            var month = value.substring(4,6);
            var day = value.substring(6,value.length);
            month = convertDateToMonth(month);
            return day + ' ' + month + ' ' + year;
        } else {
            return '';
        }
    }

    function convertDateToMonth(month) {
        switch (month) {
            case '01':
                return "Jan";
            case '02':
                return "Feb";
            case '03':
                return "Mar";
            case '04':
                return "Apr";
            case '05':
                return "Maj";
            case '06':
                return "Jun";
            case '07':
                return "Jul";
            case '08':
                return "Aug";
            case '09':
                return "Sep";
            case '10':
                return "Okt";
            case '11':
                return "Nov";
            case '12':
                return "Dec";
        }
    }

});