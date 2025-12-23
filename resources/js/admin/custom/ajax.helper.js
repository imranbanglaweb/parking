/**
 * Created by SoftBD on 2/18/2019.
 *
 */
(function ($) {

    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host + "/";

    if (typeof base_url_sub_dirs != "undefined" && base_url_sub_dirs) {
        baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + base_url_sub_dirs + "/";
    }

    var sniper = '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
    var methods = {
        init: function (options) {
            window.console.log(options.foo);
        },
        loadAjax: function (option, calback) {
            //$(".se-pre-con").show();
            var setter = $("select[name='"+option.setter+"']");
            $(setter).html('');
            $(setter).parent().append(sniper);
            $(setter).prop('disabled', true);

            var id_field = typeof option.dataField.value == 'undefined' ? '' : option.dataField.value;
            var value_field = typeof option.dataField.title == 'undefined' ? '' : option.dataField.title;

            var selected = typeof option.selected == 'undefined' ? "" : option.selected;
            var reset_fields = typeof option.reset_fields == 'undefined' ? [] : option.reset_fields;
            var postData = typeof option.postData == 'undefined' ? [] : option.postData;
            if (reset_fields.constructor != Array) throw "`reset_fields` should be array. Example: reset_fields: []";
            if (postData.constructor != Array) throw "`postData` should be array. Example: postData: [{post_field: dom_field_name/value}]";
            if (typeof option.url == 'undefined') throw "Attention! No url provided.";
            //var select_last_item = parseInt(option.select_last_item, 10);

            var data = {};
            if (postData.length > 0) {
                postData.forEach(function (a, b) {
                    var fieldValue = "";
                    switch (a.fieldType) {
                        case "select":
                            fieldValue =  $("select[name='"+a.domField+"']").val();
                            break;
                        case "input":
                            fieldValue =  $("input[name='"+a.domField+"']").val();
                            break;
                        case "checkbox":
                            fieldValue = $("input[name='"+a.domField+"']").is(':checked');
                            break;
                    }

                    data[a.postField] = fieldValue;
                })
            }

            // return;
            $.ajax({
                url: baseUrl + option.url,
                type: 'POST',
                data: data,
                success: function (data) {
                    var res = $.parseJSON(data);
                    var setter = $("select[name='"+option.setter+"']");
                    $(setter).empty();
                    $(setter).append("<option value=''>Select</option>");
                    var count = 0, last_id = 0;
                    $.each(res, function (i, v) {
                        count++;
                        var id, value = '';
                        if (value_field != '') {

                            /** check is callback */
                            if(typeof id_field.function == 'undefined'){
                                id = v[id_field];
                            }else{

                                var callBack = new Function(id_field.function.arguments, id_field.function.body);
                                id = callBack(v);
                            }

                            if(typeof value_field.function == 'undefined'){
                                value = v[value_field];
                            }else{
                                var callBack = new Function(value_field.function.arguments, value_field.function.body);
                                value = callBack(v);
                            }

                        } else {
                            if (Math.floor(v.id) == v.id && $.isNumeric(v.id)) {
                                id = v.id;
                                value = v.title;
                            } else {
                                id = i;
                                value = v;
                            }
                        }
                        last_id = id;
                        if (selected == id) {
                            $(setter).append($('<option selected></option>').text(value).attr('value', id))
                        } else {

                            $(setter).append($('<option></option>').text(value).attr('value', id))
                        }
                    });
                    // if (count == 1 && select_last_item) {
                    //     $('#' + option.setter).val(last_id);
                    // }
                    $(setter).parent().find('.lds-spinner').remove();
                    $(setter).prop('disabled', false);
                    if (reset_fields.length > 0) {
                        reset_fields.forEach(function (a, b) {
                            $('#' + a).val('');
                            $("#" + a).empty();
                            $("#" + a).append("<option value=''>Select</option>")
                        })
                    }
                    if (typeof calback != 'undefined') {
                        calback(data);
                    }
                },
                error: function (xhr, desc, err) {
                    $(setter).parent().find('.lds-spinner').remove();
                    $(setter).prop('disabled', false);
                    if (typeof calback != 'undefined') {
                        calback("error");
                    }
                }
            });
        }
    };

    $.fn.vAjax = function (methodOrOptions) {
        if (methods[methodOrOptions]) {
            return methods[methodOrOptions].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof methodOrOptions === 'object' || !methodOrOptions) {
            // Default to "init"
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + methodOrOptions + ' does not exist on jQuery.ems');
        }
    };

})(jQuery);


