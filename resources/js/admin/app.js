// window.jQuery = window.$ = $ = require('jquery');
try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = require('popper.js').default;
    require('bootstrap');
} catch (e) {}

// require('bootstrap');

window.Vue = require('vue');
window.perfectScrollbar = require('perfect-scrollbar/jquery')($);

window.moment = require('moment-timezone');

require('tempusdominus-core');
require('tempusdominus-bootstrap-4');

window.toastr = require('toastr');
window.lodash_template = require("lodash.template");

/** Data Tables */
/*window.DataTable = require('datatables');
require('datatables-bootstrap3-plugin/media/js/datatables-bootstrap3');*/

require( 'pdfmake' );
require( 'datatables.net-bs4' );
require( 'datatables.net-buttons-bs4' );
require( 'datatables.net-buttons/js/buttons.colVis.js' );
require( 'datatables.net-buttons/js/buttons.html5.js' );
require( 'datatables.net-buttons/js/buttons.print.js' );
require( 'datatables.net-responsive-bs4' );
require( 'datatables.net-scroller-bs4' );

require('jquery-match-height');
require('select2');
require('./multilingual');

require('bootstrap-switch');
require('bootstrap4-toggle/js/bootstrap4-toggle.min.js');

window.helpers = require('./helpers.js');

Vue.component('admin-menu', require('./components/admin_menu.vue').default);

var admin_menu = new Vue({
    el: '#adminmenu',
});

$(document).ready(function () {

    var appContainer = $(".app-container"),
        fadedOverlay = $('.fadetoblack'),
        hamburger = $('.hamburger');

    $('.side-menu').perfectScrollbar();

    $('#voyager-loader').fadeOut();

    $(".hamburger, .navbar-expand-toggle").on('click', function () {
        appContainer.toggleClass("expanded");
        $(this).toggleClass('is-active');
        if ($(this).hasClass('is-active')) {
            window.localStorage.setItem('voyager.stickySidebar', true);
        } else {
            window.localStorage.setItem('voyager.stickySidebar', false);
        }
    });

    if ($('.datepicker').length > 0) {
        $('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            timeZone: 'Asia/Dhaka'
        });
    }
    if ($('.datetimepicker').length > 0) {
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            timeZone: 'Asia/Dhaka'
        });
    }

    if ($('.timepicker').length > 0) {
        $('.timepicker').datetimepicker({
            format: 'HH:mm:ss',
            timeZone: 'Asia/Dhaka'
        });
    }

    $('select.select2').each(function () {
        $(this).select2({width: '100%'});
        $(this).on('select2:select', function (e) {
            var data = e.params.data;

            let dependentFields = $(this).data('dependent-fields');

            if (dependentFields && Array.isArray(dependentFields)) {
                dependentFields.forEach(function (itemVal) {
                    let elem = $("[name='" + itemVal + "']");
                    if (elem.length > 0) {
                        elem.val(null).trigger('change');
                        if (typeof elem.valid === "function") {
                            elem.valid();
                        }
                    }
                });
            }

            $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', 'selected');
            if (typeof $(e.currentTarget).valid === "function") {
                $(e.currentTarget).valid();
            }
        });

        $(this).on('select2:unselect', function (e) {
            var data = e.params.data;

            $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', false);
            if (typeof $(e.currentTarget).valid === "function") {
                $(e.currentTarget).valid();
            }
        });
    });

    $('select.select2-ajax').each(function () {
        
        let placeholder = $(this).data('placeholder');
        $(this).select2({
            width: '100%',
            placeholder: placeholder,
            allowClear: true,
            ajax: {
                url: $(this).data('get-items-route'),
                data: function (params) {
                    let dependOn = $(this).data('depend-on');
                    /*console.log(dependOn);*/
                    let filterConditions = [];
                    if (dependOn && Array.isArray(dependOn)) {
                        /* dependOn = JSON.parse(dependOn);*/
                        filterConditions = dependOn.map(function (itemVal) {
                            return $("[name='" + itemVal + "']");
                        }).filter(function (elements) {
                            return elements.length > 0 && elements.val() && elements.val().length > 0;
                        }).map(function (element) {
                            let propertyName = element.prop('name');
                            let object = {};
                            object['field'] = propertyName;
                            object['value'] = element.val();
                            return object;
                        });
                    } else if (dependOn && typeof dependOn === 'object') {
                        $.each(dependOn, function (key, item) {
                            /*console.log(key, item);*/
                            let element = $("[name='" + key + "']");
                            if (element.length > 0) {
                                if (element.val()) {
                                    let object = {};
                                    object['value'] = element.val();
                                    object['relation'] = item;
                                    filterConditions.push(object);
                                }
                            }
                        });
                    }

                    var additionalQueries = $(this).data('additional-queries');

                    if (additionalQueries && typeof additionalQueries === 'object') {
                        $.each(additionalQueries, function (key, val) {
                            if (key && val) {
                                filterConditions.push({
                                    field: key,
                                    value: val
                                })
                            }
                        });
                    }

                    var query = {
                        search: params.term,
                        type: $(this).data('get-items-field'),
                        method: $(this).data('method'),
                        page: params.page || 1
                    };

                    if (filterConditions.length > 0) {
                        query['filter_condition'] = filterConditions;
                    }

                    let additionalLabels = $(this).data('additional-labels');
                    if (additionalLabels && Array.isArray(additionalLabels) && additionalLabels.length) {
                        query['additional_fields'] = additionalLabels;
                    }

                    let searchFields = $(this).data('search-fields');
                    if (searchFields && Array.isArray(searchFields) && searchFields.length) {
                        query['search_fields'] = searchFields;
                    }

                    console.log(query);

                    return query;
                }
            }
        });

        $(this).on('select2:select', function (e) {
            var data = e.params.data;

            let dependentFields = $(this).data('dependent-fields');

            if (dependentFields && Array.isArray(dependentFields)) {
                dependentFields.forEach(function (itemVal) {
                    let elem = $("[name='" + itemVal + "']");
                    if (elem.length > 0) {
                        elem.val(null).trigger('change');
                        elem.valid();
                    }
                });
            }
            $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', 'selected');
            $(e.currentTarget).valid();
        });

        $(this).on('select2:unselect', function (e) {
            var data = e.params.data;
            /*console.log('unselect: ', data, $(this).val());*/
            $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', false);
            $(e.currentTarget).valid();
        });
    });


    $('select.select2-taggable').select2({
        width: '100%',
        tags: true,
        createTag: function (params) {
            var term = $.trim(params.term);

            if (term === '') {
                return null;
            }

            return {
                id: term,
                text: term,
                newTag: true
            }
        }
    }).on('select2:selecting', function (e) {
        var $el = $(this);
        var route = $el.data('route');
        var label = $el.data('label');
        var errorMessage = $el.data('error-message');
        var newTag = e.params.args.data.newTag;

        if (!newTag) return;

        $el.select2('close');

        $.post(route, {
            [label]: e.params.args.data.text,
        }).done(function (data) {
            var newOption = new Option(e.params.args.data.text, data.data.id, false, true);
            $el.append(newOption).trigger('change');
        }).fail(function (error) {
            toastr.error(errorMessage);
        });

        return false;
    });

    $('.match-height').matchHeight();

    $(".side-menu .nav .dropdown").on('show.bs.collapse', function () {
        return $(".side-menu .nav .dropdown .collapse").collapse('hide');
    });

    $('.panel-collapse').on('hide.bs.collapse', function (e) {
        var target = $(e.target);
        if (!target.is('a')) {
            target = target.parent();
        }
        if (!target.hasClass('collapsed')) {
            return;
        }
        e.stopPropagation();
        e.preventDefault();
    });

    $(document).on('click', '.panel-heading a.panel-action[data-toggle="panel-collapse"]', function (e) {
        e.preventDefault();
        var $this = $(this);

        // Toggle Collapse
        if (!$this.hasClass('panel-collapsed')) {
            $this.parents('.panel').find('.panel-body').slideUp();
            $this.addClass('panel-collapsed');
            $this.removeClass('voyager-angle-up').addClass('voyager-angle-down');
        } else {
            $this.parents('.panel').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
            $this.removeClass('voyager-angle-down').addClass('voyager-angle-up');
        }
    });

    //Toggle fullscreen
    $(document).on('click', '.panel-heading a.panel-action[data-toggle="panel-fullscreen"]', function (e) {
        e.preventDefault();
        var $this = $(this);
        if (!$this.hasClass('voyager-resize-full')) {
            $this.removeClass('voyager-resize-small').addClass('voyager-resize-full');
        } else {
            $this.removeClass('voyager-resize-full').addClass('voyager-resize-small');
        }
        $this.closest('.panel').toggleClass('is-fullscreen');
    });

    // Save shortcut
    $(document).keydown(function (e) {
        if ((e.metaKey || e.ctrlKey) && e.keyCode == 83) { /*ctrl+s or command+s*/
            $(".btn.save").click();
            e.preventDefault();
            return false;
        }
    });

    /** Added by Mahmud */

    $('select.select2-ajax-custom').each(function () {
        let placeholder = $(this).data('placeholder');
        $(this).select2({
            width: '100%',
            placeholder: placeholder,
            allowClear: true,
            ajax: {
                url: $(this).data('url'),
                method: 'post',
                data: function (params) {
                    let model = $(this).data('model');
                    if (!model) {
                        return {};
                    }

                    var query = {
                        model: model,
                        page: params.page || 1,
                        type: 'select2'
                    };

                    if (params.term) {
                        query['search'] = params.term;
                    }
                    let dependOn = $(this).data('depend-on');

                    let filterConditions = {};
                    if (dependOn && Array.isArray(dependOn)) {
                        dependOn.map(function (itemVal) {
                            return $("[name='" + itemVal + "']");
                        }).filter(function (elements) {
                            return elements.length > 0 && elements.val() && elements.val().length > 0;
                        }).forEach(function (element) {
                            let propertyName = element.prop('name');
                            filterConditions[propertyName] = element.val();
                        });
                    } else if (dependOn && typeof dependOn === 'object') {
                        $.each(dependOn, function (key, dbFieldName) {
                            /*console.log(key, dbFieldName);*/
                            let element = $("[name='" + key + "']");
                            if (element.length > 0) {
                                if (element.val().length > 0) {
                                    filterConditions[dbFieldName] = element.val();
                                }
                            }
                        });
                    }

                    if (dependOn && Object.keys(filterConditions).length === 0) {
                        return false;
                    }
                    let relation = $(this).data('relation');
                    let relationDependOn = $(this).data('relation-depend-on');

                    let relationFilterConditions = {};

                    if (relation && relationDependOn && typeof relationDependOn === 'object') {
                        $.each(relationDependOn, function (key, dbFieldName) {
                            /*console.log(key, dbFieldName);*/
                            let element = $("[name='" + key + "']");

                            if (element.length > 0) {
                                if (element.val() && element.val().length > 0) {
                                    relationFilterConditions[dbFieldName] = element.val();
                                }
                            }
                        });
                    }

                    var additionalQueries = $(this).data('additional-queries');

                    if (additionalQueries && typeof additionalQueries === 'object') {
                        $.each(additionalQueries, function (key, val) {
                            if (key && val) {
                                filterConditions[key] = val;
                            }
                        });
                    }

                    /*console.log(filterConditions, relationFilterConditions);*/
                    if (Object.keys(filterConditions).length > 0) {
                        query['filters'] = filterConditions;
                    }
                    if (Object.keys(relationFilterConditions).length > 0) {
                        query['relation_filters'] = relationFilterConditions;
                        query['relation'] = relation;
                    }
                    let label = $(this).data('label');
                    if (label) {
                        query['label'] = label;
                    }
                    let key = $(this).data('key');
                    if (key) {
                        query['key'] = key;
                    }


                    let additionalLabels = $(this).data('additional-labels');
                    if (additionalLabels && Array.isArray(additionalLabels) && additionalLabels.length) {
                        query['additional_fields'] = additionalLabels;
                    }

                    let searchFields = $(this).data('search-fields');
                    if (searchFields && Array.isArray(searchFields) && searchFields.length) {
                        query['search_fields'] = searchFields;
                    }

                    return query;
                }
            }
        });

        $(this).on('select2:select', function (e) {
            var data = e.params.data;

            let dependentFields = $(this).data('dependent-fields');

            if (dependentFields && Array.isArray(dependentFields)) {
                dependentFields.forEach(function (itemVal) {
                    let elem = $("[name='" + itemVal + "']");
                    if (elem.length > 0) {
                        elem.val(null).trigger('change');
                        elem.valid();
                    }
                });
            }
            $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', 'selected');
            $(e.currentTarget).valid();
        });

        $(this).on('select2:unselect', function (e) {
            var data = e.params.data;
            /*console.log('unselect: ', data, $(this).val());*/
            $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', false);
            $(e.currentTarget).valid();
        });
    });

    $('.datatable').DataTable({
        "dom": '<"top"fl<"clear">>rt<"bottom"ip<"clear">>'
    });
});
