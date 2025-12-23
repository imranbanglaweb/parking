<?php


namespace App\Http\Controllers;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    public function index(Request $request)
    {

        //return response()->json($inputs);
        /*
         *  type: 'normal|select2',
         *  model: "\App\Models\Designation"
         *  page: 1
         *  label: 'name'
         *  search: 'ceo'
         *
         *  // optional:
         *  key: id,
         *  filters: [
         *     another_field: 1,
         *  ]
         *  relation:  "companies"
         *  relation_filters: [
         *     "id": 1
         *  ]
         */
        $inputs = $request->input();

        if (!empty($inputs['model'])) {
            $model = app($inputs['model']);
            /** @var $model \Illuminate\Database\Eloquent\Model */
            try {
                if ($model instanceof $inputs['model']) {
                    $page = $request->input('page');
                    $on_page = 50; /* per page */
                    $skip = $on_page * ($page - 1);
                    $search = $request->input('search', false);
                    $keyField = !empty($inputs['key']) ? $inputs['key'] : 'id';
                    $labelField = !empty($inputs['label']) ? $inputs['label'] : 'title';

                    if (!empty($inputs['additional_fields']) && is_array($inputs['additional_fields'])) {
                        $selectedColumns = [$keyField];
                        $selectedColumns = array_merge($selectedColumns, $inputs['additional_fields']);
                    } else {
                        $selectedColumns = [$keyField, $labelField];
                    }

                    $query = $model->select($selectedColumns);
                    if (!empty($inputs['filters']) && is_array($inputs['filters'])) {
                        collect($inputs['filters'])->each(function ($value, $key) use ($query) {
                            if (!empty($value) && is_scalar($value)) {
                                $query->where($key, $value);
                            }
                        });
                    }

                    if (!empty($inputs['relation']) && !empty($inputs['relation_filters']) && is_array($inputs['relation_filters'])) {
                        $relation = $inputs['relation'];
                        $condition = [];
                        foreach ($inputs['relation_filters'] as $key => $val) {
                            if (!empty($key) && !empty($val)) {
                                $condition[] = [$relation . "." . $key, '=', $val];
                            }
                        }
                        if (count($condition)) {
                            $query->whereHas($relation, function (Builder $q) use ($condition) {
                                $q->where($condition);
                            });
                        }
                    }
                    if ($search) {
                        $searchFields = [];
                        if (!empty($inputs['search_fields']) && is_array($inputs['search_fields'])) {
                            $searchFields = $inputs['search_fields'];
                        }

                        if (count($searchFields) > 0) {
                            $query->where(function ($thisQuery) use ($search, $searchFields) {
                                foreach ($searchFields as $searchField) {
                                    $thisQuery->orWhere($searchField, 'LIKE', '%' . $search . '%');
                                }
                                return $thisQuery;
                            });
                        } else {
                            $query->where($labelField, 'LIKE', '%' . $search . '%');
                        }

                        $total_count = $query->count();
                        $result = $query->take($on_page)->skip($skip)
                            ->get();
                    } else {
                        $total_count = $query->count();
                        $result = $query->take($on_page)->skip($skip)->get();
                    }

                    if (isset($inputs['type']) && $inputs['type'] == 'select2') {
                        $data = [];
                        foreach ($result as $row) {
                            $data[] = ['text' => $row->{$labelField}, 'id' => $row->{$keyField}];
                        }

                        return response()->json([
                            'results' => $data,
                            'pagination' => [
                                'more' => ($total_count > ($skip + $on_page)),
                            ],
                        ]);
                    }

                    return $result->pluck($labelField, $keyField);
                }
            } catch (\Exception $ex) {
                return response()->json(["error" => $ex->getMessage()], 404);
            }

        }
        return response()->json(["error" => "Not Found"], 404);
    }

    /**
     *  SMS Sending Example
     * public function oneSmsToMany(Request $request)
     * {
     *
     * $validationRules = [
     * 'sms_type' => 'required',
     * 'employee_ids' => 'required|array|min:1',
     * 'message' => 'required|min:1',
     * 'content_type' => ['required', Rule::in(['unicode', 'text'])]
     * ];
     *
     * $this->validate($request, $validationRules);
 *
* $smsService = new SmsSenderService();
 *
* $employeesContactNumbers = Employee::select('contact_number')
            * ->whereIn('id', $request->input('employee_ids'))
            * ->where('status', 1)->get()
            * ->pluck('contact_number')
            * ->all();
 *
* $validContacts = [];
        * foreach ($employeesContactNumbers as $contactNumber) {
            * $pos = stripos($contactNumber, '+');
            * if ($pos === 0) {
                * $validContacts[] = substr($contactNumber, 1);
            * } else if ($pos === false) {
                * $validContacts[] = $contactNumber;
            * }
        * }
 *
* if (count($validContacts) === 0) {
            * return response()->json(['errors' => [__('No valid employee contact found with provided ids.')]], 400);
        * }
        * $smsConfig = SmsConfig::acl()->where('api_type', SmsConfig::API_TYPE_ONE_TO_MANY)->first();
 *
* if (!$smsConfig) {
            * return response()->json(['errors' => [__('No SMS configuration has been found.')]], 400);
        * }
 *
* try {
 *
* $response = $smsService->oneToMany(implode('+', $validContacts), $request->message)
                * ->send($smsConfig, $request->content_type);
 *
* if (!empty($response['result'])) {
 *
* DB::table('sms_sending_logs')->insert([
                    * 'sms_type' => $request->sms_type,
                    * 'contacts' => json_encode($validContacts),
                    * 'api_response' => $response['result'],
                    * 'content_type' => $request->content_type,
                    * 'created_at' => Carbon::now()->format('Y-m-d H:i:s')
     * ]);
     *
     * if (stripos($response['result'], 'SMS SUBMITTED') !== false) {
     * return response()->json(['success' => true, 'message' => __('SMS has been successfully sent.')], 200);
     * }
     * }
     * return response()->json(['errors' => __("Problem in sending the sms.")], 400);
     * } catch (\Exception $exception) {
     * return response()->json(['errors' => [$exception->getMessage()]], 400);
     * }
     * }*/
}
