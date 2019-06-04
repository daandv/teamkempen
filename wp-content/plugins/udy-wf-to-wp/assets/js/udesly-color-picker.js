(function ($) {

    $(function () {

        $(document).ready(function () {

            $.each($('.cdg-woo-kit-color-field'), function () {
                $(this).iris({
                    change: function (event, ui) {
                        var $el = $(event.target).find('input');
                        $el.attr('value', ui.color.toString());
                        $('.colorpicker-preview',event.target).css('background-color', ui.color.toString());
                    },
                    color: $('input', this).val()
                });

                $('.colorpicker-preview', this).css('background-color', $('input', this).val());
            });

            $('.cdg-woo-kit-color-field').on('focusin', function () {
                $(this).iris('show');
            });

            $(window).on('click', function (e) {
                if (!$(e.target).parents('.cdg-woo-kit-color-field').length == 1) {
                    $('.cdg-woo-kit-color-field').iris('hide');
                }
            });
        });
    });

})(jQuery);