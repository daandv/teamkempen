(function( $ ) {
    'use strict';

    $(document).ready(function () {


        // ---------------------------------------- TABS ------------------------------------------
        $('.cdg-woo-kit-tabs-component-wrapper').each(function () {
            $('.cdg-woo-kit-tabs li:first', $(this)).addClass('active');
            $('.cdg-woo-kit-panels .cdg-woo-kit-panel:first', $(this)).addClass('active');
        })

        $('.cdg-woo-kit-tabs-component-wrapper .cdg-woo-kit-tabs li').on('click', function () {
            var data_tab_id = $(this).attr('data-tab-id');
            $('li', $(this).closest('.cdg-woo-kit-tabs') ).removeClass('active');
            $(this).addClass('active');
            $('.cdg-woo-kit-panel', $(this).closest('.cdg-woo-kit-tabs-component-wrapper')).removeClass('active');
            $('.cdg-woo-kit-panel[data-panel-id="' + data_tab_id + '"]', $(this).closest('.cdg-woo-kit-tabs-component-wrapper')).addClass('active');
        });

        $('.cdg-woo-kit-ui-datepicker').datepicker();
        $('.cdg-woo-kit-ui-datetimepicker').datetimepicker();

        var hash = window.location.hash;
        if (!isEmpty(hash)) {
            hash = hash.replace('#','');
            var udesly_tab = $('.cdg-woo-kit-tabs li[data-tab-id="' + hash + '"]');
            if (udesly_tab.length !== 0) {
                udesly_tab.trigger('click');
            }
        }
    });

    function isEmpty(value) {
        return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
    }

})( jQuery );
