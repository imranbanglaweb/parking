<!DOCTYPE html>
<html lang="en">
     <?php
    if(isset($station_data->logo)){
        $logo='url(public/storage/'.$station_data->logo.')';
        $logo = str_replace('\\', '/', $logo);
}
    ?>
    <head>

                <style>
            * {
    font-size: 10px;
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
    width: 90px;
    height: 90px;
    border-radius: 50%;
    display: flex; /* or inline-flex */
    align-items: center;
    justify-content: center;
    border: 2px solid #000;
    font: 24px Arial;
    font-weight:bold;
    margin-left:30%;
}
.logo-print{
       width:60px;
       margin-left:34.5%;
       margin-top:-5px;
       display: list-item;
       list-style-image: <?php echo $logo; ?>;
       list-style-position: inside;
   }

@media print {
     img{
          display: inline;
          visibility: visible;
     }
     .ticket {
    width: 260px;
    max-width:260px;
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
       margin-left:9%;
       display: list-item;
        list-style-image: <?php echo $logo; ?>;
       list-style-position: inside;
   }
}
        </style>
    </head>
    <body>
        <div class="ticket">
            <div class="centered logo-print" >
            </div>

            <table style="width:100%">

                <tbody class="centered">
                     <tr>
                        <td class="description centered"><strong class="centered">{{$station_data->project_title}}</strong></td>

                    </tr>
                    <tr>
                        <td style="font-size:15px;font-weight:bold" class="description centered"><strong>Token No#</strong> {{$parking_data->token_number}}</td>

                    </tr>
                     <tr>
                        <td class="description centered"><strong>Vehicle Type:</strong> {{$parking_data->vehicle_type}}</td>
                    </tr>
                    <tr>
                        <td class="description centered" style="font-size:12px"><strong style="font-size:12px">Vehicle No: {{$parking_data->area.'-'.$parking_data->code.' '.$parking_data->vehicle_number}}</strong></td>
                    </tr>
                    <tr>
                        <td style="font-size:12px" class="description centered"><strong>In Time:</strong> {{Date('d-M-Y H:i:s',strtotime($parking_data->clock_in))}}</td>

                    </tr>



                </tbody>
            </table>
            <p style="font-size:9px">
                <strong style="font-style: italic">Terms & Conditions:</strong><br />
            1. Parking fee non-refundable / Parking card not transferable.<br />
            2. This entry only applies to one entry only.<br />
            3. The owner / driver will park the car at his own risk.<br />
            4. After parking, the authority will not have any responsibility for the inside, outside or any other matter of the vehicle.<br />
            5. Show receipt when exiting.

            <table style="width:100%">

                <tbody class="centered">

                    <tr>
                        <td class="centered">Developed by IT, UG </td>

                    </tr>

                </tbody>
            </table>

        </div>

    </body>
</html>