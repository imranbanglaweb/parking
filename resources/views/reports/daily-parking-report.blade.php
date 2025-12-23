<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html" >
        <meta name="description" content="Free Web tutorials">
        <meta name="keywords" content="HTML, CSS, JavaScript">
        <meta name="author" content="John Doe">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .number{
                font-family:'bangla';
            }
            .header-top{
                font-family:'sans-serif';
                width: 100%;

            }
            #report-table {
                width: 100%;
                border-collapse: collapse;
                font-size:12px;
            }
            .header-table{
                width: 100%;
                border-collapse: collapse;
                font-size:12px;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 5px;
                text-align: left;
            }
            .pd{
                border:none
            }
            .header-top{text-align: center}
            .header-top p{font-size: 14px;line-height: .5}
            .mujib-100{float:right;overflow: hidden;display: block}
            .title-bar h4{line-height: .7}
        </style>
    </head>
    <body>
<!--
        <div class='mujib-100'>
            <img src="{{ asset('public/images/mujib.png')}}" alt="Mujib" width="120" height="130" style='margin-top:-10px'>
        </div>-->

        <div class="header-top">
<!--            <img style="margin-left:128px" src="{{ asset('public/images/header.PNG')}}"  alt="">-->
            <h4 style="margin-top:-15px">Daily Collection Report</h4>
        </div>
        <div class="title-bar">
        <h4>Date: {{$test_date}}</h4>
        </div>
       <br />
        <table id="report-table">
            <thead>
                <tr>
                   <th class="no-space">{{__('S/L')}}</th>
                    <th class="no-space">{{__('Vehile Number')}}</th>
                    <th class="no-space">{{__('Tenant')}}</th>
                    <th class="no-space">{{__('Vehicle Type')}}</th>
                    <th class="no-space">{{__('Station')}}</th>
                    <th class="no-space">{{__('Token Number')}}</th>
                    <th class="no-space">{{__('Mobile Number')}}</th>
                    <th class="no-space">{{__('In Time')}}</th>
                    <th class="no-space">{{__('Out Time')}}</th>
                    <th class="no-space">{{__('Total Time')}}</th>
                    <th class="no-space">{{__('Payable Amount')}}</th>
                    <th class="no-space">{{__('Paid Amount')}}</th>
                    <th class="no-space">{{__('Collector')}}</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($parkings as $key => $report)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td style="width:100px"><span class="number">{{ $report->code}}</span> <span>{{ $report->vehicle_number}}</span></td>
                    <td>{{ $report->tenant }}</td>
                    <td>{{ $report->vehicle_type }}</td>
                    <td>{{ $report->station }}</td>
                    <td>{{ $report->token_number }}</td>
                    <td>{{ $report->mobile_number }}</td>
                    <td>{{ $report->clock_in }}</td>
                    <td>{{ $report->clock_out }}</td>
                    <td>{{ $report->total_time }}</td>
                    <td>{{ $report->payable_amount }}</td>
                    <td>{{ $report->paid_amount }}</td>
                    <td>{{ $report->collector }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>


    </body>
</html