(function ($) {
    'use strict';

    $(document).ready(function () {

        $('#delete-frontend-editor-elements').on('click', function () {

            var data = {
                'action': 'delete_frontend_editor_page_elements',
                'post_id': $(this).attr('data-post-id')
            };

            $.post(ajax_object.ajax_url, data, function (response) {
                if (response) {
                    var counter = $('.udesly-fe-el-count');
                    counter.html('0');
                    $('.delete_all_page_elements_msg').show();
                }
                //window.location.reload(true);
            });
        });


    });

})(jQuery);
