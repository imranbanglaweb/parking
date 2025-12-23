@section('validation')
    @php
        $edit = !is_null($dataTypeContent->getKey());
        $add  = is_null($dataTypeContent->getKey());
        $triggers = [];
        $jqueryValidationRules = [];
        $jqueryValidationMessages = [];
        $jqueryValidationEdit =[];
        $vAjaxRequest = [];
        $triggers = [];
    @endphp
    @if(isset($dataTypeRows) && isset($dataTypeContent))
        @foreach($dataTypeRows as $row)
            @php
                $optionDetails = null; $columnName = null;
                if( $row->type == 'relationship'){
                    $optionDetails = !empty($row->additional_details) ? $row->additional_details : null;
                    $columnName = $row->details->column;
                } else  {
                    $columnName = $row->field;
                    $optionDetails = $row->details;
                }
            @endphp
            @php

                if($optionDetails && isset($optionDetails->trigger) && isset($optionDetails->trigger->dependents_fields) &&
                $optionDetails->trigger->dependents_fields && isset($optionDetails->trigger->dependent_value) &&
                !is_null($optionDetails->trigger->dependent_value) &&  isset($optionDetails->trigger->action) && $optionDetails->trigger->action){
                    $triggers[$columnName] = [
                        'action' => $optionDetails->trigger->action,
                        'value' => $optionDetails->trigger->dependent_value,
                        'fields' => $optionDetails->trigger->dependents_fields
                    ];
                }
                if($edit){
                    if($optionDetails && !empty($optionDetails->frontend_validation) && !empty($optionDetails->frontend_validation->edit->rules)) {
                        $jqueryValidationRules[$columnName] = $optionDetails->frontend_validation->edit->rules;
                    } else{
                        if($optionDetails && !empty($optionDetails->frontend_validation) && !empty($optionDetails->frontend_validation->rules)){
                            $jqueryValidationRules[$columnName] = $optionDetails->frontend_validation->rules;
                        }
                    }
                    if($optionDetails && !empty($optionDetails->frontend_validation) && !empty($optionDetails->frontend_validation->messages)) {
                        $jqueryValidationMessages[$columnName]= $optionDetails->frontend_validation->messages;
                    }
                } else  {
                    if($optionDetails && !empty($optionDetails->frontend_validation) && !empty($optionDetails->frontend_validation->add->rules)) {
                        $jqueryValidationRules[$columnName] = $optionDetails->frontend_validation->add->rules;
                    } else {
                        if($optionDetails && !empty($optionDetails->frontend_validation) && !empty($optionDetails->frontend_validation->rules)){
                            $jqueryValidationRules[$columnName] = $optionDetails->frontend_validation->rules;
                        }
                    }
                    if($optionDetails && !empty($optionDetails->frontend_validation) && !empty($optionDetails->frontend_validation->messages)) {
                        $jqueryValidationMessages[$columnName] = $optionDetails->frontend_validation->messages;
                    }
                }

                $column = "";
                $ajaxRequest = null;
/*                if($row->type == 'relationship'){
                    $column = $row->details->column;
                    // dd($row->additional_details);
                    if(!empty($row->additional_details->render) ){
                        $ajaxRequest = $row->additional_details->render;
                    }
                } else{
                    $column = $row->field;
                    // $tmpDetails = (array) $row->details->rander;
                    if(isset($row->details->render)){
                        $ajaxRequest = $row->details->render;
                    }
                }
                if(!empty($ajaxRequest)){
                    $vAjaxRequest[] = [
                        'column' => $column,
                        'render' => $ajaxRequest
                    ];
                }*/
            @endphp
        @endforeach

    @endif
    <script src="{{ asset('public/backend_resources/js/jquery_validation_combine.js') }}"></script>
    <script>
        function formTriggerCheck(actionName, triggerValue, fields, selectedVal){
            if(!Array.isArray(fields)){
                return false;
            }
            var len = fields.length;
            for(var i = 0; i < len; i++) {
                if (fields[i]) {
                    $('input[name="'+fields[i]+'"], select[name="'+fields[i]+'"]').each(function(index1, elem1){
                        if(actionName === 'show' && selectedVal === triggerValue){
                            $(elem1).parent().show();
                        } else if(actionName === 'show'){
                            $(elem1).parent().hide();
                        } else if(actionName === 'hide' && selectedVal === triggerValue){
                            $(elem1).parent().hide();
                        } else if(actionName === 'hide'){
                            $(elem1).parent().show();
                        }
                    });
                }
            }
        }
        $('document').ready(function () {
           // alert('i am here');
            var formTriggers = null;
            @if(count($triggers))
                formTriggers =  @json($triggers, JSON_PRETTY_PRINT);
             @endif
              console.log(formTriggers);

              if(formTriggers){
                  $.each(formTriggers, function (column, triggerVals) {
                      if(!Array.isArray(triggerVals.fields)){
                          return false;
                      }
                        var actionName = triggerVals.action;
                        var triggerValue = triggerVals.value;

                       $('input[name="'+column+'"],select[name="'+column+'"]')
                           .on('change', function(e){
                               var selectedVal = $(this).val();
                               formTriggerCheck(actionName, triggerValue, triggerVals.fields, selectedVal);
                           })
                           .each(function(index, elem){
                               var selectedVal = $(elem).val();
                               formTriggerCheck(actionName, triggerValue, triggerVals.fields, selectedVal);
                            });

                  });
              }
            /** Adding Jquery Validation rules **/
            $.validator.addMethod(
                "regex",
                function(value, element, regexp) {
                    var re = new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },
                "{{__("Invalid Input")}}"
            );

            var addEditForm = $('form.form-edit-add');

            var jqueryValidationRules = @if ($jqueryValidationRules) '{!! addslashes(json_encode($jqueryValidationRules)) !!}'; @else "";  @endif
            var jqueryValidationMessages = @if ($jqueryValidationMessages) @json($jqueryValidationMessages, JSON_PRETTY_PRINT); @else { }; @endif

                console.log(jqueryValidationRules);

            jqueryValidationRules = JSON.parse(jqueryValidationRules, function(key, elem) {

                if(typeof elem.remote != 'undefined' && typeof elem.remote.data != 'undefined') {
                    $.each(elem.remote.data, function (fieldName, fieldElem) {
                        if(typeof fieldElem == 'string' && fieldElem.includes('function') ) {
                            elem.remote.data[fieldName] = eval("(" + fieldElem + ")")
                        }
                    })
                }
                return elem;
            });

            if (addEditForm.length) {
                addEditForm.validate({
                    onkeyup: false,
                    ignore: [],
                    rules: jqueryValidationRules,
                    messages: jqueryValidationMessages,
                    errorElement: "em",
                    errorPlacement: function (error, element) {
                        // Add the `help-block` class to the error element
                        error.addClass("help-block");

                        // Add `has-feedback` class to the parent div.form-group
                        // in order to add icons to inputs
                        element.parents(".form-group").addClass("has-feedback");

                        if (element.prop("type") === "checkbox") {
                            error.insertAfter(element.parent("label"));
                        } else if(element.hasClass('select2-ajax') || element.hasClass('select2')) {
                            error.insertAfter(element.parents(".form-group").find('.select2-container'));
                        } else {
                            error.insertAfter(element);
                        }

                        // Add the span element, if doesn't exists, and apply the icon classes to it.
                        /*                        if ( !element.next( "span" )[ 0 ] ) {
                        $( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );
                        }*/
                    },
                    submitHandler: function(form){
                        $('#voyager-loader').show();
                        form.submit();
                    },
                    success: function (label, element) {
                        // Add the span element, if doesn't exists, and apply the icon classes to it.
                        /*                        if ( !$( element ).next( "span" )[ 0 ] ) {
                        $( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );
                        }*/
                    },
                    highlight: function (element, errorClass, validClass) {
                        $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                        /*   $( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );*/
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
                        /*  $( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );*/
                    }
                });
            }
        });
    </script>
@stop
