jQuery(document).ready(function ($) {

    $(document).on('click', '.hbg-event-widget-search', function (e) {
        e.preventDefault();
        var $form = $(this).parents('form').first();
        var searchString = $form.find('input.hbg-event-widget-search-string').val();

        var data = {
            action: 'hbgPostEventLoad',
            q: searchString
        };

        $form.find('.hbg-event-widget-search-post-id select').html('');
        $.post(ajaxurl, data, function (response) {
            $form.find('.hbg-event-widget-search-post-id select').html(response);
            $form.find('.hbg-event-widget-search-post-id').show();
            $form.find('.hbg-event-widget-search-post-title').val($form.find('.hbg-post-inherit-post-id select option').first().text());
        });
    });

    $(document).on('change', '.hbg-event-widget-search-post-id', function (e) {
        var $form = $(this).parents('form').first();
        $form.find('.hbg-event-widget-search-post-title').val($(this).find('option:selected').text());
    });

});