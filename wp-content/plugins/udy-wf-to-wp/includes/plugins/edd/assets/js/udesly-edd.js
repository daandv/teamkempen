(function( $ ) {
    'use strict';

    $(document).ready(function () {
        cart_update();
        $('[udesly-data="purchase-link"] [udesly-data="add-to-cart"] ').on('click', function(e){
            var purchase_link = $(this).closest('[udesly-data="purchase-link"]');
            purchase_link.find('[udesly-data="add-to-cart"]').hide();
            purchase_link.find('[udesly-data="loader"]').show();
            purchase_link.find('a[data-action="edd_add_to_cart"]').trigger('click');
        });

        $(document).ajaxComplete(function( event, xhr, settings ) {

            if(!settings.data){
                return;
            }

            var action = GetURLParameter('action', settings.data);

            if(action == 'edd_add_to_cart'){
                var download_id = GetURLParameter('download_id', settings.data);
                $('#udesly_edd_purchase_link_' + download_id).find('[udesly-data="loader"]').hide();
                $('#udesly_edd_purchase_link_' + download_id).find('[udesly-data="checkout"]').show();
                $('div.edd-cart-quantity').html($('span.edd-cart-quantity').html());
            }

            if(action == 'edd_remove_from_cart'){
                cart_update();
            }
        });
    });


    function cart_update() {
        $('[udesly-data="add-to-cart"]').show();
        $('[udesly-data="checkout"]').hide();
        $.each($('ul.edd-cart li a[data-download-id]'), function(i,e){
            var download_id = $(this).attr('data-download-id');
            $('#udesly_edd_purchase_link_' + download_id).find('[udesly-data="add-to-cart"]').hide();
            $('#udesly_edd_purchase_link_' + download_id).find('[udesly-data="checkout"]').show();
        });
        $('div.edd-cart-quantity').html($('span.edd-cart-quantity').html());

        $.each($('[udesly-data="purchase-link"]'), function (i,e) {
            var edd_style = $(this).find('[data-action="edd_add_to_cart"]').attr('style');
            if(edd_style && !~edd_style.indexOf('display: none;')){
                $(this).find('[udesly-data="add-to-cart"]').hide();
                $(this).find('[udesly-data="checkout"]').show();
            }
        });
    }

    function GetURLParameter(sParam, sPageURL){
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++){
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam){
                return sParameterName[1];
            }
        }
    }
})( jQuery );