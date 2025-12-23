<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">
                <i class="voyager-plus"></i> {{ __('Vehicle Out from Parking') }}
            </h4>
            <button type="button" class="close" data-dismiss="modal"
                    aria-label="{{ __('voyager::generic.close') }}">
                <span aria-hidden="true">&times;</span>
            </button>


        </div>
        <div class="modal-body" id="add_test_model_body">

            <form class="form-edit-add" role="form" id="vehicle_out_form"
                  action="#"
                  method="POST" enctype="multipart/form-data" autocomplete="off">

                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            {{-- <div class="panel"> --}}
                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="alert alert-danger" style="display:none"></div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <input type="text" style="display:none" class="form-control" id="o_tenant_id" name="o_tenant_id"
                                               placeholder=""
                                               value="{{$parking_data->tenant_id}}">
                                         <input type="text" style="display:none" class="form-control" id="o_id" name="o_id"
                                               placeholder=""
                                               value="{{$parking_data->id}}">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="token_number">{{ __('bread.daily-parkings.token_no') }}</label>
                                                <input type="text" readonly="readonly"  class="form-control" id="o_token_number" name="o_token_number"
                                                       placeholder=""
                                                       value="{{$parking_data->token_number}}">
                                            </div>
                                        </div>
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tenant">{{ __('bread.daily-parkings.tenants') }}</label>
                                                <input type="text" readonly="readonly"  class="form-control"
                                                       placeholder=""
                                                       value="{{$parking_data->tenant}}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="vehicle_number">{{ __('bread.daily-parkings.vehicle_number') }}</label>
                                                <input type="text" readonly="readonly"  class="form-control" id="o_vehicle_number" name="o_vehicle_number"
                                                       placeholder=""
                                                       value="{{$parking_data->vehicle_number}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="display:none">
                                            <div class="form-group">
                                                <label class="required" for="vehicle_type_id">{{ __('bread.daily-parkings.vehicle_type') }}</label>
                                                <input type="text" readonly="readonly"  class="form-control" id="o_vehicle_type_id" name="o_vehicle_type_id"
                                                       placeholder=""
                                                       value="{{$parking_data->vehicle_type_id}}">
                                            </div>
                                        </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="vehicle_type">{{ __('bread.daily-parkings.vehicle_type') }}</label>
                                                <input type="text" readonly="readonly"  class="form-control" id="vehicle_type" name="vehicle_type"
                                                       placeholder=""
                                                       value="{{$parking_data->vehicle_type}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="clock_in">{{ __('bread.daily-parkings.clock_in') }}</label>
                                                <input type="text" readonly="readonly"  class="form-control" id="o_clock_in" name="o_clock_in"
                                                       placeholder=""
                                                       value="{{$parking_data->clock_in}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="clock_out">{{ __('bread.daily-parkings.clock_out') }}</label>
                                                <input type="text" readonly="readonly"  class="form-control" id="o_clock_out" name="o_clock_out"
                                                       placeholder=""
                                                       value="{{date('Y-m-d H:i:s' )}}">
                                            </div>
                                        </div>
                                        <?php
                                        $total_amount=0;
                                        $last_hour = 0;
                                        $date1 = $parking_data->clock_in;
                                        $date2 = date('Y-m-d H:i:s');
                                        $timestamp1 = strtotime($date1);
                                        $timestamp2 = strtotime($date2);
                                        $minuits = ceil(abs($timestamp2 - $timestamp1) / (60));
                                        $hour=0;
                                        if ($minuits > 60) {
                                            $hour=ceil(abs(($minuits-5)/60));
                                        }else{
                                            $hour=ceil(abs($minuits/60));
                                        }

                                        if ($hour > 1) {
                                            $last_hour = $hour - 1;
                                        }
                                        if($parking_data->payment_status=='Paid'){
                                        $total_amount = round($rate->first_hour * 1 + $rate->next_hour * $last_hour);
                                        }
                                        ?>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="total_time">{{ __('bread.daily-parkings.total_time') }}</label>
                                                <input type="text" readonly="readonly"  class="form-control" id="o_total_time" name="o_total_time"
                                                       placeholder=""
                                                       value="{{$hour}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="payable_amount">{{ __('bread.daily-parkings.total_amount') }}</label>
                                                <input type="text" readonly="readonly"  class="form-control" id="o_payable_amount" name="o_payable_amount"
                                                       placeholder=""
                                                       value="{{$total_amount}}">
                                            </div>
                                        </div>
                                         @if($parking_data->payment_status=='Paid')
                                         <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="required" for="o_paid_amount">{{ __('bread.daily-parkings.paid_amount') }}</label>
                                                <input type="text"  class="form-control" id="o_paid_amount" name="o_paid_amount"
                                                       placeholder=""
                                                       value="{{$total_amount}}">
                                            </div>
                                        </div>
                                         @endif

                                    </div>
                                </div>

                                <div class="row">
                                    <input type="hidden" name="locale" value="bn" id="locale">
                                    <div class="col-md-12 text-right">
                                        <div class="form-group text-center">
                                            <!--user permission end here-->
                                            <button type="submit" class="btn btn-primary save">
                                                <i class="fa fa-plus"></i>
                                                {{ __('voyager::generic.save') }}
                                            </button>
                                            <button type="button" class="btn btn-default pull-right"
                                                    data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

        </div>
        </form>
    </div>

</div>
</div>

<script>
    $("#vehicle_out_form").validate({
        rules: {
            'o_vehicle_type_id': {
                required: true
            },
            'o_token_number': {
                required: true
            },
            'o_clock_in': {
                required: true
            },
            'o_vehicle_number': {
                required: true
            },
            'o_clock_out': {
                required: true
            },
            'o_total_amount': {
                required: true
            },
            'o_payable_amount': {
                required: true
            },
            'o_paid_amount': {
                required: true
            },
            errorPlacement: function (error, element)
            {
                if (element.is(":radio"))
                {
                    error.appendTo(element.parents('.front-error'));
                }

            }
        },
        submitHandler: function (form) {

            $('#voyager-loader').show();
            $('.saving').show();
            $('.save').hide();
            $.ajax({
                url: "{{route('daily-parkings.out')}}",
                type: "POST",
                data: $('#vehicle_out_form').serialize(),
                success: function (data) {
                    console.log(data);
                    $('#vehicle_out_form').trigger("reset");
                    /* reseting form */
                    $('.alert-danger').hide();
                    $('#voyager-loader').hide();
                    $('.saving').hide();
                    $('.save').show();
                    toastr.success(data.success);
                    w = window.open();
                    w.document.write(data.receit);
                    w.print();
                    w.close();
                    location.reload();
                },

                error: function (data) {
                    console.log(data);
                    $('#voyager-loader').hide();
                    $('.saving').hide();
                    $('.save').show();
                    $.each(data.responseJSON.errors, function (key, value) {
                        $('.alert-danger').html('');
                        $('.alert-danger').append('<p>' + value + '</p>');
                        $('.alert-danger').show();
                    });
                    setTimeout(function () {
                        $('.alert-danger').fadeOut(1000)
                    }, 3000);
                }
            });
        }
    });
</script>