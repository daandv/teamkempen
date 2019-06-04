(function ($) {
    'use strict';

    var regex = /<div style="display: none;" id="udesly-edd-mini-cart-items">(.*)<\/div>/g;
    var cart_items = [];
    var cart_quantity = $('[udesly-edd-el="mini-cart-items"] li').length - 1;
    $(document.body).on('edd_cart_item_added', function (event, res) {
        var item =  regex.exec(res.cart_item);

        var cart_total = res.total;
        cart_quantity = parseInt(res.cart_quantity);

        if(item[1]){
            cart_items = JSON.parse(item[1]);
            refreshCartItems(cart_items);
        }

        refreshCartActions(cart_total, cart_quantity);

    });

    function refreshCartActions(cart_total, cart_quantity) {
        console.log('Quantity', cart_quantity, 'Total', cart_total);

        if (cart_quantity == 0) {
            $('[udesly-edd-el="mini-cart-actions"]').hide();
            $('[udesly-edd-el="no-items-in-cart"]').show();
            $('[data-node-type="commerce-cart-form"]').hide();
        }else {
            $('[data-node-type="commerce-cart-form"]').show();
            $('[udesly-edd-el="mini-cart-actions"]').show();

            if (cart_total) {
                $('[udesly-edd-el="mini-cart-actions"] [udesly-edd-el="total"]').html(cart_total);
            }

            $('[udesly-edd-el="no-items-in-cart"]').hide();
        }
        $('.edd-cart-quantity').html(cart_quantity);
    }

    function refreshCartItems(cart_items) {
        var dummyCartItem = $('.udesly-edd-mini-cart-dummy-item');
        var dummyHTML = dummyCartItem.wrap('<div></div>').parent().html();

        if(!dummyHTML){
            return;
        }

        var cartItemsContainer = dummyCartItem.closest('[udesly-edd-el="mini-cart-items"]');
        var result = '';
        cart_items.forEach( function (element) {
            var currentHTML = dummyHTML.replace(/{{title}}/, element.title);
            currentHTML = currentHTML.replace(/{{permalink}}/, element.permalink);
            currentHTML = currentHTML.replace(/{{quantity}}/, element.quantity);
            currentHTML = currentHTML.replace(/{{remove_url}}/, getURLParameters(element.remove_url));
            currentHTML = currentHTML.replace(/{{remove_url_nonce}}/, element.remove_url_nonce);
            currentHTML = currentHTML.replace(/{{remove_url_item_id}}/, element.remove_url_item_id);
            currentHTML = currentHTML.replace(/{{remove_url_cart_item_id}}/, element.remove_url_cart_item_id);
            currentHTML = currentHTML.replace(/{{image}}/, element.image);
            currentHTML = currentHTML.replace(/udesly-edd-mini-cart-dummy-item/, element.class);
            result += currentHTML;
        });
        cartItemsContainer.html(result);
    }

    function toggleModal() {
        var toggleButton = $('[data-node-type="commerce-cart-open-link"]');
        toggleButton.on('click', function(e) {
            var wrapper = $(this).closest('[data-node-type="commerce-cart-wrapper"]');
            if (wrapper) {
                const modal = wrapper.find('[data-node-type="commerce-cart-container-wrapper"]');
                modal.show();
            }

        });

        $('body').on('click', '[data-node-type="commerce-cart-close-link"]', function(e) {
            var wrapper = $(this).closest('[data-node-type="commerce-cart-wrapper"]');
            if (wrapper) {
                const modal = wrapper.find('[data-node-type="commerce-cart-container-wrapper"]');
                modal.hide();
            }
        });
        $('body').on('click', '[data-node-type="commerce-cart-container-wrapper"]', function(e) {
            var wrapper = $(this).closest('[data-node-type="commerce-cart-wrapper"]');
            if (wrapper) {
                const modal = wrapper.find('[data-node-type="commerce-cart-container-wrapper"]');
                modal.hide();
            }
        });

    }

    $( function() {
        toggleModal();
        refreshCartActions(null, cart_quantity);
    });


    function getURLParameters(sPageURL){
        return sPageURL.slice(sPageURL.indexOf('?'));
    }
})(jQuery);