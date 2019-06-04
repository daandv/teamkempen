(function( $ ) {
    'use strict';

    $(document).ready(function () {
        $('[udesly-woo-el="orderby"] select').on('change', function (e) {
            var value = $( this ).serialize();
            window.location.href = window.location.origin + window.location.pathname + '?' + value;
        });
    });

})( jQuery );