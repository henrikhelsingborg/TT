jQuery(document).ready(function ($) {

    $(document).on('click', '[data-action="search-post-type-content"]', function (e) {
        e.preventDefault();
        var $form = $(this).parents('form').first();
        var $contentSelect = $form.find('[data-inherit-content]');

        var searchString = $form.find('[data-inherit-q]').val();
        var postType = $form.find('[data-inherit-posttype]').val();

        var data = {
            action: 'hbgInheritLoadPosts',
            q: searchString,
            type: postType
        };

        $contentSelect.html();
        $.post(ajaxurl, data, function (response) {
            $contentSelect.html(response);
            $contentSelect.parents('p').first().show();
        });
    });

});