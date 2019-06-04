//------------------------------------- Rules --------------------------------------
(function( $ ) {
    'use strict';

    $(document).ready(function () {

        $('.select2-wf-to-wp select').each(function (i,e) {
            var data_set = {
                'action': 'select2_search',
                'subject': $(this).attr('subject'),
                'multiple': $(this).is("[multiple]"),
                'query_meta': $(this).attr('query_meta'),
                'minimum_input_length': $(this).attr('minimum_input_length'),
                'minimum_results_for_search': $(this).attr('minimum_results_for_search')
            };

            $(this).select2({
                ajax: {
                    url: ajax_login_object.ajaxurl, // AJAX URL is predefined in WordPress admin
                    dataType: 'json',
                    delay: 250, // delay in ms while typing when to perform a AJAX search
                    data: function (params) {
                        if(data_set.subject === 'contenttaxonomy'){
                            var post_type = $('[name="query_builder[post_type][]"]').val();
                            params.term += '#' + post_type;
                        }else if(data_set.subject === 'contentterm'){
                            var taxonomy = $('[name="query_builder[contenttaxonomy][]"]').val();
                            params.term += '#' + taxonomy;
                        }
                        return {
                            q: params.term, // search query
                            action: data_set.action, // AJAX action for admin-ajax.php
                            subject: data_set.subject,
                            query_meta: data_set.query_meta
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                minimumInputLength: data_set.minimum_input_length,
                width: '100%',
                multiple: data_set.multiple,
                minimumResultsForSearch: data_set.minimum_results_for_search
            });
        });

        $('.click-to-select').on('click', function (event) {
            $(this).select();
        });

        $('body').on('change', '[name="query_builder[post_type][]"]', tab_visibility);

        tab_visibility();

    });

    function tab_visibility() {
        var post_type = $('[name="query_builder[post_type][]"]');
        var tab_cat = $('[data-tab-id="category"]');
        var tab_tag = $('[data-tab-id="tag"]');
        var tab_tax = $('[data-tab-id="taxonomy"]');
console.log(post_type.val());
        if(post_type.val() === 'post' || post_type.val() === null){
            tab_cat.show();
            tab_tag.show();
            tab_tax.hide();
        }else{
            tab_cat.hide();
            tab_tag.hide();
            tab_tax.show();
        }
    }

})( jQuery );