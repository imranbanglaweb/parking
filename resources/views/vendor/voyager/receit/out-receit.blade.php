<!DOCTYPE html>
<html lang="en">
    <?php
    if(isset($station_data->logo)){
        $logo='url(public/storage/'.$station_data->logo.')';
        $logo = str_replace('\\', '/', $logo);
}
    ?>
    <head>
<link rel="preload" href="{{ voyager_asset('images/logo.jpg') }}" as="image" />
        <style>
            * {
    font-size: 12px;
    font-family: 'Arial';
}

td,
th,
tr,
table {
    border-top: 0px solid black;
    border-collapse: collapse;
    text-align: center;
}


.centered {
    text-align: center;
    align-content: center;
}

.ticket {
    width: 260px;
    max-width: 260px;
}


.numberCircle {
    border-radius: 50%;
    width: 50px;
    height: 50px;
    padding: 20px;
    margin:20px;
    background: #fff;
    border: 2px solid #666;
    color: #666;
    text-align: center;
    margin-left:7px;
    font: 32px Arial, sans-serif;
}
img {
    -webkit-print-color-adjust: exact;
}
@media print {
    img{
          display: inline;
          visibility: visible;
     }
     .ticket {
    width: 260px;
    max-width: 260px;
}
.centered {
    text-align: center;
    align-content: center;
}
td,
th,
tr,
table {
    border-top: 0px solid black;
    border-collapse: collapse;
    text-align: center;
}
     .logo-print{
       width:220px;
       margin-left:5%;
       margin-top:-5px;
       display: list-item;
       list-style-image: <?php echo $logo; ?>;
       list-style-position: inside;
       position: relative
   }
   img{
          display: inline;
          visibility: visible;
     }
}
        </style>
    </head>
    <body>
        <div class="ticket" style="margin-left:25px">
            <div class="centered logo-print" >

            </div>
            <table>

                <tbody>

                    <tr>
                        <td class="description centered"><strong class="centered">{{$station_data->project_title}}</strong></td>

                    </tr>
                    <tr>
                        <td class="description centered"><strong>Token Number:</strong> {{$parking_data->token_number}}</td>

                    </tr>
                    <tr>
                        <td class="description centered"><strong>Vehicle Type:</strong> {{$parking_data->vehicle_type}}</td>
                    </tr>
                    <tr>
                        <td class="description centered" style="font-size:14px"><strong style="font-size:16px">Vehicle No:</strong> {{$parking_data->area.'-'.$parking_data->code.' '.$parking_data->vehicle_number}}</td>
                    </tr>
                    <tr>
                        <td class="description centered"><strong>In Time:</strong> {{Date('d-M-Y H:i:s',strtotime($parking_data->clock_in))}}</td>

                    </tr>
                    <tr>
                        <td class="description centered"><strong>Out Time:</strong> {{Date('d-M-Y H:i:s',strtotime($parking_data->clock_out))}}</td>

                    </tr>
                    <tr>
                        <td class="description centered"><strong>Total Time:</strong> {{$parking_data->total_time}} Hour's</td>

                    </tr>
                    <tr>
                        <td class="description centered"><strong style="font-size:14px">Total Amount:</strong> {{$parking_data->payable_amount}} Tk.</td>

                    </tr>
                    <tr>
                        <td class="description centered" style="font-size:10px" >Developed by IT, UG </td>

                    </tr>




                </tbody>
            </table>

        </div>

    </body>
</html>