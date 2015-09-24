jQuery(document).ready(function ($) {
    $('.hbg-help-form').on('submit', function (e) {
        e.preventDefault();

        // Set up post data
        var data = {
            action: 'submit_comment',
            postid: $('#input-post-id').val(),
            comment: $('#input-comment').val()
        }

        $form = $(this);
        $container = $form.parents('.help-container');

        // Show loading indicatir in the submit button
        $form.find('button[type="submit"]').html('<i class="dots-loading"></i>');

        // Post the comment with ajax
        $.post(ajaxurl, data, function (response) {
            if (response == 'true') {
                $container.find('.tooltip').hide();
                $container.find('.answers').hide();
                $container.find('.thanks').show();
            }
        });
    });

    $('[data-action="hbg-help-submit-response"]').on('click', function (e) {
        e.preventDefault();

        $container = $(this).parents('.help-container');

        var data = {
            action: 'submit_response',
            postid: $('#input-post-id').val(),
            answer: $(this).val()
        }

        $.post(ajaxurl, data, function (response) {
            if (data.answer == 'yes' && response == 'true') {
                $container.find('.answers').hide();
                $container.find('.thanks').show();
            }
        })
    });
});