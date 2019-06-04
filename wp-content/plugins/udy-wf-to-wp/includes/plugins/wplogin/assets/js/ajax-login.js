jQuery(document).ready(function($) {

    var register_form =  $('form[udesly-wp-ajax="register"]');
    register_form.find('[type="submit"]').prop('disabled',true);

    var password_reset_form = $('form[udesly-wp-ajax="reset-password"]');
    password_reset_form.find('[type="submit"]').prop('disabled',true);

    // Perform AJAX login on form submit
    $('form[udesly-wp-ajax="login"]').on('submit', function(e){
        var form = $('form[udesly-wp-ajax="login"]');
        var formParent = form.closest('.w-form');
        formParent.find(".w-form-done").hide();
        formParent.find(".w-form-fail").hide();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': form.find('[name="log"]').val(), 
                'password': form.find('[name="pwd"]').val(), 
                'security': form.find('#security').val() },
            success: function(data){
                if (data.loggedin == true){
                   form.hide();
                   formParent.find(".w-form-done").show();

                   var redirect = formParent.find("input[name='redirect_to']");
                   if(redirect.length){
                       var redirect_url = redirect.val();
                       if(redirect_url.length){
                           window.location.href = redirect_url;
                       }
                   }

                }else{
                    formParent.find(".w-form-fail [udesly-data='error-message']").html(data.message);
                    formParent.find(".w-form-fail").show();
                }
            },
            error: function(){
                formParent.find(".w-form-fail").show();
            }
        });
        e.preventDefault();
    });

    $('input[name="password_repeat"]',register_form).on('input', function () {
        if($('[name="password"]',register_form).val() !== $(this).val()){
            register_form.find('[type="submit"]').prop('disabled',true);
            $(this).addClass('udesly-error');
        }else{
            register_form.find('[type="submit"]').prop('disabled',false);
            $(this).removeClass('udesly-error');
        }
    });

    $('input[name="password_repeat"]',password_reset_form).on('input', function () {
        if($('[name="password"]',password_reset_form).val() !== $(this).val()){
            password_reset_form.find('[type="submit"]').prop('disabled',true);
            $(this).addClass('udesly-error');
        }else{
            password_reset_form.find('[type="submit"]').prop('disabled',false);
            $(this).removeClass('udesly-error');
        }
    });
   
    // Perform AJAX register on form submit
    register_form.on('submit', function(e){
        var form = $('form[udesly-wp-ajax="register"]');
        var formParent = form.closest('.w-form');
        formParent.find(".w-form-done").hide();
        formParent.find(".w-form-fail").hide();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'register_user', //calls wp_ajax_nopriv_register_user
                'username': form.find('[name="username"]') ? form.find('[name="username"]').val() : '', 
                'password': form.find('[name="password"]').val(), 
                'password_repeat': form.find('[name="password_repeat"]').val(),
                'security': form.find('#security').val(),
                'mail': form.find('[type="email"]').val(),
                'first_name': form.find('[name="first_name"]').length ? form.find('[name="first_name"]').val() : '',
                'last_name': form.find('[name="last_name"]').length ? form.find('[name="last_name"]').val() : '',
            },
            success: function(data){
                if (data.status == true){
                   form.hide();
                   formParent.find(".w-form-done").show();

                    var redirect = formParent.find("input[name='redirect_to']");
                    if(redirect.length){
                        var redirect_url = redirect.val();
                        if(redirect_url.length){
                            window.location.href = redirect_url;
                        }
                    }
                }else{
                    formParent.find(".w-form-fail").show();
                    formParent.find(".w-form-fail [udesly-data='error-message']").html(data.message);
                }
            },
            error: function(){
                formParent.find(".w-form-fail").show();
            }
        });

        e.preventDefault();
    });

    $('form[udesly-wp-ajax="lost-password"]').on('submit', function(e){
        var form = $('form[udesly-wp-ajax="lost-password"]');
        var formParent = form.closest('.w-form');
        formParent.find(".w-form-done").hide();
        formParent.find(".w-form-fail").hide();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'lost_password', //calls wp_ajax_nopriv_ajaxlogin
                'user_login': form.find('[name="user_login"]').val(),
                'page_slug': $('body').attr('udesly-page-name'),
                'security': form.find('#security').val()
            },
            success: function(data){
                if (data.error == false){
                    form.hide();
                    formParent.find(".w-form-done").show();
                }else{
                    formParent.find(".w-form-fail").show();
                    formParent.find(".w-form-fail [udesly-data='error-message']").html(data.errormessage);
                }
            },
            error: function(){
                formParent.find(".w-form-fail").show();
            }
        });
        e.preventDefault();
    });

    $('form[udesly-wp-ajax="reset-password"]').on('submit', function(e){
        var form = $('form[udesly-wp-ajax="reset-password"]');
        var formParent = form.closest('.w-form');
        formParent.find(".w-form-done").hide();
        formParent.find(".w-form-fail").hide();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: {
                'action': 'reset_password', //calls wp_ajax_nopriv_ajaxlogin
                'user_key': form.find('[name="user_key"]').val(),
                'user_login': form.find('[name="user_login"]').val(),
                'password': form.find('[name="password"]').val(),
                'password_repeat': form.find('[name="password_repeat"]').val(),
                'security': form.find('#security').val()
            },
            success: function(data){
                if (data.error == false){
                    form.hide();
                    formParent.find(".w-form-done").show();
                }else{
                    formParent.find(".w-form-fail").show();
                    formParent.find(".w-form-fail [udesly-data='error-message']").html(data.errormessage);
                }
            },
            error: function(){
                formParent.find(".w-form-fail").show();
            }
        });
        e.preventDefault();
    });

});