jQuery(document).ready(function($) {

    var udesly_form =  $('[udesly-wp-ajax="form"]');

    // Perform AJAX login on form submit
    udesly_form.on('submit', function(e){

        var input_serialize = $(this).serializeArray();
        var udesly_form_parent = udesly_form.closest('.w-form');

        console.log(input_serialize);

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_form_object.ajaxurl,
            data: {
                'action': 'send_form',
                'form_data': input_serialize
            },
            success: function(data){
                if (data.form_sent == true){
                    udesly_form.hide();
                    udesly_form_parent.find(".w-form-done").show();

                    var formParent = udesly_form.closest('.w-form');
                    var redirect = formParent.find("input[name='redirect_to']");
                    if(redirect.length){
                        var redirect_url = redirect.val();
                        if(redirect_url.length){
                            window.location.href = redirect_url;
                        }
                    }

                }else{
                    udesly_form_parent.find(".w-form-fail").show();
                }
            },
            error: function(){
                udesly_form_parent.find(".w-form-fail").show();
            }
        });
        e.preventDefault();
    });

});