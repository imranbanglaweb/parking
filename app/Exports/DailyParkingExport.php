<?php

namespace App\Exports;

use App\Models\CustomerBooking;
use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Counter;
use App\Models\InventoryItem;
use App\Models\DailyParking;
use App\Models\CustomerCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
Use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DailyParkingExport implements FromCollection, WithHeadings, WithTitle
{
    use Exportable;
    protected $data;

    function __construct($data) {
        $this->data=$data;
       // dd($this->data);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $authUser = Auth::user();
        $start_date='';
        $end_date='';

        if($this->data['start_date']!=null && $this->data['end_date']==null){
             $start_date = $this->data['start_date'].' '.'00:00:00';
             $end_date = $this->data['start_date'].' '.'23:59:59';
        }
        if($this->data['start_date']==null && $this->data['end_date']!=null){
            $start_date = $this->data['end_date'].' '.'00:00:00';
            $end_date = $this->data['end_date'].' '.'23:59:59';
        }
        if($this->data['start_date']!=null && $this->data['end_date']!=null){
            $start_date = $this->data['start_date'].' '.'00:00:00';
            $end_date = $this->data['end_date'].' '.'23:59:59';
        }


        $today=Carbon::now()->format('d_m_Y');
            $parkings = DB::table('daily_parkings')->select(
                        DB::raw("CONCAT(a.name,'-',c.name,' ',daily_parkings.vehicle_number) AS vehicle_number"),
                        't.name as tenant',
                        'v.name as vehicle_type',
                        's.name as station',
                        'daily_parkings.token_number',
                        'daily_parkings.mobile_number',
                        'daily_parkings.clock_in',
                        'daily_parkings.clock_out',
                        'daily_parkings.total_time',
                        'daily_parkings.payable_amount',
                        'daily_parkings.paid_amount',

                        DB::raw( '(SELECT name FROM users u WHERE u.id = daily_parkings.collection_by) as collector')

                    )

                    ->leftJoin('tenants as t', 't.id', '=', 'daily_parkings.tenant_id')
                    ->leftJoin('stations as s', 's.id', '=', 'daily_parkings.station_id')
                    ->leftJoin('vehicle_types as v', 'v.id', '=', 'daily_parkings.vehicle_type_id')
                    ->leftJoin('areas as a', 'a.id', '=', 'daily_parkings.area_id')
                    ->leftJoin('codes as c', 'c.id', '=', 'daily_parkings.code_id')
                    ->where('daily_parkings.clock_out','!=',NULL);

            if ($this->data['start_date']==null && $this->data['end_date']==null){
                $parkings->whereDate('daily_parkings.clock_out', Carbon::now()->format('Y-m-d'));
            }else{
            $parkings->whereBetween('daily_parkings.clock_out',[$start_date, $end_date]);
            }
            $parkings->when(!empty($this->data['station_id']), function ($query) use ($start_date) {
                        return $query->where('daily_parkings.station_id',$this->data['station_id']);
            });
            $parkings->when(!empty($this->data['tenant_id']), function ($query) use ($start_date) {
                        return $query->where('daily_parkings.tenant_id',$this->data['tenant_id']);
            });
            $parkings->when(!empty($this->data['vehicle_type_id']), function ($query) use ($start_date) {
                        return $query->where('daily_parkings.vehicle_type_id',$this->data['vehicle_type_id']);
            });
            $parkings->when(!empty($this->data['vehicle_number']), function ($query) use ($start_date) {
                        return $query->where('daily_parkings.vehicle_number',$this->data['vehicle_number']);
            });
            $parkings->when(!empty($this->data['payment_status']), function ($query) use ($start_date) {
                        return $query->where('daily_parkings.payment_status',$this->data['payment_status']);
            });
             $parkings->when(!empty($this->data['collection_by']), function ($query) use ($start_date) {
                        return $query->where('daily_parkings.collection_by',$this->data['collection_by']);
            });

            if(!Auth::user()->isAdmin()){
                $parkings->where('daily_parkings.station_id',$authUser->station_id);
            }


            $parkings->orderBy('daily_parkings.id','DESC');
            $parkings = $parkings->get();


            $collection_date='';
            if($this->data['start_date']!=null && $this->data['end_date']==null){
                 $collection_date=date('d.m.Y', strtotime($this->data['start_date']));
            }
            if($this->data['start_date']==null && $this->data['end_date']!=null){
                 $collection_date=date('d.m.Y', strtotime($this->data['end_date']));
            }

            if($this->data['start_date']!=null && $this->data['end_date']!=null){
                $collection_date=date('d.m.Y', strtotime($this->data['start_date'])).' - '.date('d.m.Y', strtotime($this->data['end_date']));

            }

            if($this->data['start_date']==null && $this->data['end_date']==null){
                $collection_date=Carbon::now()->format('Y-m-d');
            }
        return $parkings;
    }
    public function headings(): array
    {
        return [
            'Vehicle Number',
            'Tenant',
            'Vehicle Type',
            'Station',
            'Token Number',
            'Mobile Number',
            'In Time',
            'Out Time',
            'Total Time',
            'Payable Amount',
            'Paid Amount',
            'Collector',
        ];
    }
   public function title(): string
    {
        return 'Daily Parking Collection';
    }

}
