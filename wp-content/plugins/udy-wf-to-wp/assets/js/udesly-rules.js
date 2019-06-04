//------------------------------------- Rules --------------------------------------
(function ($) {
    'use strict';

    $(document).ready(function () {

        $.each($('.cdg-woo-kit-form'), function () {
            var rule_group_logic_operator = $('input[name^="rule_group_logic_operator"]', $(this)).val();
            var rule_conditions = $('select[name^="rule_conditions"]', $(this)).val();

            var preselected_options = {};

            if ($('select[name^="rule_group"] option', $(this)).length) {
                var options = $('select[name^="rule_group"] option', $(this));
                preselected_options = $.map(options, function (option) {
                    var obj = {id: option.value, text: option.text};
                    return obj;
                });
            }

            if ($('input[name="rule_group[]"]', $(this)).length) {
                preselected_options = $('input[name="rule_group[]"]', $(this)).val();
            }

            createAndSetRules($('select[name^="rule_subject"]', $(this)), rule_group_logic_operator, rule_conditions, preselected_options);

        });

        $('body').on('click', '.add_and_rule_group button', function () {
            var rule_group = $(this).closest('.cdg-woo-kit-form').clone();
            $(this).closest('.cdg-woo-kit-form').after(rule_group);
            $('select[name^="rule_subject"] option[value=always]', rule_group).remove();
            $('input[name^="rule_group_logic_operator"]', rule_group).val('and');
            $('h3', rule_group).text(i18n.logic_and);

            createAndSetRules($('select[name^="rule_subject"]', rule_group), 'and', null, null);
        });

        $('body').on('click', '.add_or_rule_group button', function () {
            var rule_group = $(this).closest('.cdg-woo-kit-form').clone();
            $(this).closest('.cdg-woo-kit-form').after(rule_group);
            $('select[name^="rule_subject"] option[value=always]', rule_group).remove();
            $('input[name^="rule_group_logic_operator"]', rule_group).val('or');
            $('h3', rule_group).text(i18n.logic_or);

            createAndSetRules($('select[name^="rule_subject"]', rule_group), 'or', null, null);
        });

        $('body').on('click', '.remove_rule_group button', function () {

            var id = get_id($(this));

            if ($('#' + id + ' .cdg-woo-kit-form').length > 1) {
                $(this).closest('.cdg-woo-kit-form').remove();
                $('#' + id + ' .cdg-woo-kit-form h3:first').text(i18n.rules_group_title);
            }

            $.each($('#' + id + ' .cdg-woo-kit-form select[name^="rule_subject"]'), function (i, val) {
                indexRuleGroup($(this), 'select[multiple]', 'rule_group');
            });
        });

        $('body').on('change', 'select[name^="rule_subject"]', function () {
            var rule_group_logic_operator = $('input[name^="rule_group_logic_operator"]', $(this).closest('.cdg-woo-kit-form')).val();
            createAndSetRules($(this), rule_group_logic_operator, null, null);
        });

    });

    function get_id(el) {
        var id;
        if (el.closest('.postbox').length !== 0)
            id = el.closest('.postbox').attr('id');
        else
            id = el.closest('.cdg-woo-kit-custom-meta-box').attr('id');

        return id;
    }

    function indexRuleGroup(rule_subject_field, input_element, name) {

        var id = get_id(rule_subject_field);

        var index = $('#' + id + ' .cdg-woo-kit-form').index(rule_subject_field.closest('.cdg-woo-kit-form'));

        $(input_element + '[name^="' + name + '"]', rule_subject_field.closest('.cdg-woo-kit-form')).attr('name', name + '[' + index + '][]');
    }

    function createAndSetRules(rule_subject_field, rule_group_logic_operator, rule_conditions, preselected_options) {

        var data_set = {
            'action': 'udesly_load_rule_conditions',
            'subject': rule_subject_field.val()
        };

        if (rule_subject_field.val() == 'always') {

            var id = get_id(rule_subject_field);
            $('#' + id + ' .cdg-woo-kit-form').not(':first').remove();

        }

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data_set, function (response) {
            //cleaning rules after subject change
            $('select[name^="rule_conditions"]', $(rule_subject_field).closest('.cdg-woo-kit-form')).closest('.cdg-woo-kit-form-field').remove();
            $('select[name^="rule_group"]', $(rule_subject_field).closest('.cdg-woo-kit-form')).closest('.cdg-woo-kit-form-field').remove();
            $('input[name^="rule_group"]', $(rule_subject_field).closest('.cdg-woo-kit-form')).closest('.cdg-woo-kit-form-field').remove();
            $('input[name^="rule_group_logic_operator"]', $(rule_subject_field).closest('.cdg-woo-kit-form')).closest('.cdg-woo-kit-form-field').remove();
            $('.rule_group_btn', $(rule_subject_field).closest('.cdg-woo-kit-form')).closest('.cdg-woo-kit-form-field').remove();

            if (response != '') {
                rule_subject_field.closest('.cdg-woo-kit-form-field').after(response);

                if (rule_group_logic_operator == 'and' || rule_group_logic_operator == 'or') {
                    $('input[name^="rule_group_logic_operator"]', rule_subject_field.closest('.cdg-woo-kit-form')).val(rule_group_logic_operator);
                }
                if (rule_conditions) {
                    $('select[name^="rule_conditions"]', rule_subject_field.closest('.cdg-woo-kit-form')).val(rule_conditions);
                }

                $('select[name^="rule_group"]', rule_subject_field.closest('.cdg-woo-kit-form')).attr('name', 'rule_group[]');

                switch (rule_subject_field.val()) {
                    case 'products' :
                    case 'product_category' :
                    case 'product_tags' :
                    case 'user' :
                    case 'is_post_type_archive':
                        indexRuleGroup(rule_subject_field, 'select', 'rule_group');
                        select2Init($(rule_subject_field), preselected_options, data_set, 2, true, 0);
                        break;
                    case 'is_category':
                    case 'woo_products':
                    case 'woo_has_user_purchased':
                    case 'woo_is_category':
                    case 'woo_is_tag':
                    case 'is_tag':
                        indexRuleGroup(rule_subject_field, 'select', 'rule_group');
                        select2Init($(rule_subject_field), preselected_options, data_set, 2, true, 0);
                        var $rule_conditions_select = $('[name="rule_conditions[]"]', $(rule_subject_field).closest('.cdg-woo-kit-form'));
                        if($rule_conditions_select.val() == 'any' || $rule_conditions_select.val() == 'none'){
                            $('.cdg-woo-kit-form-field.rule_group', $(rule_subject_field).closest('.cdg-woo-kit-form')).hide();
                        }
                        $rule_conditions_select.on('change', function () {
                            if ($(this).val() == 'any' || $(this).val() == 'none') {
                                $('.cdg-woo-kit-form-field.rule_group', $(rule_subject_field).closest('.cdg-woo-kit-form')).hide();
                            }else{
                                $('.cdg-woo-kit-form-field.rule_group', $(rule_subject_field).closest('.cdg-woo-kit-form')).show();
                            }
                        });
                        break;
                    case 'product_type':
                    case 'sale_status':
                    case 'stock_status':
                    case 'edd_has_user_purchased' :
                    case 'rcp_has_subscription':
                        select2Init($(rule_subject_field), preselected_options, data_set, 0, false, -1);
                        break;
                    case 'role' :
                        indexRuleGroup(rule_subject_field, 'select', 'rule_group');
                        select2Init($(rule_subject_field), preselected_options, data_set, 0, true, -1);
                        break;
                    case 'product_price' :
                    case 'stock_quantity' :
                        $('input[name="rule_group[]"]', $(rule_subject_field).closest('.cdg-woo-kit-form')).val(preselected_options);
                        break;
                    case 'date' :
                        $('input[name="rule_group[]"]', $(rule_subject_field).closest('.cdg-woo-kit-form')).val(preselected_options);
                        $('.cdg-woo-kit-ui-datetimepicker').datetimepicker();
                    default :
                        $('select[name="rule_group[]"]', $(rule_subject_field).closest('.cdg-woo-kit-form')).hide();
                        break;
                }
            }

        });
    }

    function select2Init(rule_subject_field, preselected_options, data_set, minimumInputLength, multiple, minimumResultsForSearch) {
        $('select[name^="rule_group"]', rule_subject_field.closest('.cdg-woo-kit-form')).select2({
            ajax: {
                url: ajaxurl, // AJAX URL is predefined in WordPress admin
                dataType: 'json',
                delay: 250, // delay in ms while typing when to perform a AJAX search
                data: function (params) {
                    return {
                        q: params.term, // search query
                        action: 'udesly_search_in_rule_group', // AJAX action for admin-ajax.php
                        subject: data_set.subject
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            },
            minimumInputLength: minimumInputLength,
            width: '100%',
            multiple: multiple,
            minimumResultsForSearch: minimumResultsForSearch
        });

        if (preselected_options) {
            Object.keys(preselected_options).forEach(function (key) {
                $('select[name^="rule_group"]', rule_subject_field.closest('.cdg-woo-kit-form')).append('<option value="' + preselected_options[key].id + '" selected="selected">' + preselected_options[key].text + '</option>');
            });
        }
    }
})(jQuery);