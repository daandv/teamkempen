//------------------------------------- Rules --------------------------------------
(function( $ ) {
    'use strict';

    $(document).ready(function () {

        $('#udesly-pages-sync-btn').on('click', function (event) {

            $('.udesly-success-msg, .udesly-error-msg').hide();

            var prev_text = $('#udesly-pages-sync-btn').html();
            loader(true, $('#udesly-pages-sync-btn'), prev_text);

            var data = {
                'action': 'pages_sync',
                'pages_sync_nonce' : ajax_login_object.pages_sync_nonce,
                'udesly_action': 'wp_load_importer'
            };

            jQuery.post(ajax_login_object.ajaxurl, data, function(response) {
                loader(false, $('#udesly-pages-sync-btn'), prev_text);
                $('.' + response).show();
            }, 'json').fail(function() {
                loader(false, $('#udesly-pages-sync-btn'), prev_text);
            });
        });

        var import_action = getUrlParameter('import-pages-data');
        if (typeof import_action !== "undefined" && import_action == 'start') {
            console.log('start');
            $('#udesly-pages-sync-btn').trigger( "click" );
        }

        $('#udesly-delete-pages-btn').on('click', function (event) {

            $('.udesly-success-msg, .udesly-error-msg').hide();

            var prev_text = $('#udesly-delete-pages-btn').html();
            loader(true, $('#udesly-delete-pages-btn'), prev_text);

            var data = {
                'action': 'delete_all_pages',
                'delete_all_pages_nonce' : ajax_login_object.delete_all_pages_nonce,
            };

            jQuery.post(ajax_login_object.ajaxurl, data, function(response) {
                loader(false, $('#udesly-delete-pages-btn'), prev_text);
                $('.' + response).show();
            }, 'json').fail(function() {
                loader(false, $('#udesly-delete-pages-btn'), prev_text);
            });
        });

        $('#udesly-delete-fe-btn').on('click', function (event) {

            $('.udesly-success-msg, .udesly-error-msg').hide();

            var prev_text = $('#udesly-delete-fe-btn').html();
            loader(true, $('#udesly-delete-fe-btn'), prev_text);

            var data = {
                'action': 'delete_all_fe_elements',
                'delete_all_fe_elements_nonce' : ajax_login_object.delete_all_fe_elements_nonce,
            };

            jQuery.post(ajax_login_object.ajaxurl, data, function(response) {
                loader(false, $('#udesly-delete-fe-btn'), prev_text);
                $('.' + response).show();
            }, 'json').fail(function() {
                loader(false, $('#udesly-delete-fe-btn'), prev_text);
            });
        });

        $('#udesly-clean-fe-btn').on('click', function (event) {

            $('.udesly-success-msg, .udesly-error-msg').hide();

            var prev_text = $('#udesly-clean-fe-btn').html();
            loader(true, $('#udesly-clean-fe-btn'), prev_text);

            var data = {
                'action': 'clean_all_fe_elements',
                'clean_all_fe_elements_nonce' : ajax_login_object.clean_all_fe_elements_nonce,
            };

            jQuery.post(ajax_login_object.ajaxurl, data, function(response) {
                loader(false, $('#udesly-clean-fe-btn'), prev_text);
                $('.' + response).show();
            }, 'json').fail(function() {
                loader(false, $('#udesly-clean-fe-btn'), prev_text);
            });
        });
    });

    function loader(status, buttonRef, originalContent) {
        if(status){
            buttonRef.html(originalContent + ' <i class="fa fa-spinner fa-fw fa-spin"></i>');
            buttonRef.prop("disabled",true);
        }else{
            buttonRef.html(originalContent);
            buttonRef.prop("disabled",false);
        }
    }

    function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

})( jQuery );