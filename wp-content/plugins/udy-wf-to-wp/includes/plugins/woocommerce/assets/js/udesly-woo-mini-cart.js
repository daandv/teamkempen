(function ($) {
    'use strict';

    $(document.body).on('wc_fragments_loaded' , function () {
        refreshCartCount();
        refreshCartActions();
        refreshCartItems();
    });


    function refreshCartCount() {
        var cartCount = $('#udesly-woocommerce-mini-cart-count').text();
        $('[udesly-woo-el="cart-count"]').text(cartCount);
    }

    function refreshCartActions() {
        var cartCount = $('#udesly-woocommerce-mini-cart-count').text();
        if (cartCount == 0) {
            $('[udesly-woo-el="mini-cart-actions"]').hide();
            $('[udesly-woo-el="no-items-in-cart"]').show();
            $('[data-node-type="commerce-cart-form"]').hide();
        }else {
            $('[data-node-type="commerce-cart-form"]').show();
            $('[udesly-woo-el="mini-cart-actions"]').show();
            var subtotal = $('#udesly-woocommerce-mini-cart-subtotal').text();
            $('[udesly-woo-el="mini-cart-actions"] [udesly-woo-el="cart-subtotal"]').html(subtotal);
            $('[udesly-woo-el="no-items-in-cart"]').hide();
        }
    }

    function refreshCartItems() {
        var dummyCartItem = $('.udesly-woocommerce-mini-cart-dummy-item');
        var dummyHTML = dummyCartItem.wrap('<div></div>').parent().html();
        if(!dummyHTML){
            return;
        }

        var cartItemsContainer = dummyCartItem.closest('.w-dyn-items');
        var newCartItemsContainer = dummyCartItem.closest('[udesly-woo-el="mini-cart-items"]');
        var cartItems = JSON.parse($('#udesly-woocommerce-mini-cart-items').text());

        var result = '';
        cartItems.forEach( function (element) {
            var currentHTML = dummyHTML.replace(/{{title}}/, element.title);
            currentHTML = currentHTML.replace(/{{permalink}}/, element.permalink);
            currentHTML = currentHTML.replace(/{{quantity}}/, element.quantity);
            currentHTML = currentHTML.replace(/{{remove_url}}/, element.remove_url);
            currentHTML = currentHTML.replace(/{{image}}/, element.image);
            currentHTML = currentHTML.replace(/udesly-woocommerce-mini-cart-dummy-item/, element.class);
            result += currentHTML;
        });

       cartItemsContainer && cartItemsContainer.html(result);
       newCartItemsContainer && newCartItemsContainer.html(result);

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
        refreshCartCount();
        refreshCartActions();
        refreshCartItems();
    });


})(jQuery);