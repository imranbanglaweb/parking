<?php


namespace App\Http\Controllers;

use App\Mail\registrationMail;
use App\Models\Role;
use App\Models\User;
use App\Models\UsersPermission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use TCG\Voyager\Facades\Voyager;
use Yajra\DataTables\Facades\DataTables;

class RegisterController extends Controller
{

    function register(Request $request)
    {
        $user = app(User::class);
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|regex:/^01[1-9][0-9]{8}$/|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->all()], 400);
        }


        $inputs = $request->input();
        $attributes = [
            'name', 'email', 'user_type', 'mobile', 'status', 'role_id'
        ];

        foreach ($inputs as $field => $value) {
            if (in_array($field, $attributes)) {
                $user->{$field} = $value;
            }
        }
        $code = str_random(6);
        $user->user_type='normal_user';
        $user->role_id=3;
        $user->otp=$code;
        $user->status=0;

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $name = 'users/' . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/users');
            $image->move($destinationPath, $name);
            $user->avatar = $name;
        }


        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        DB::beginTransaction();

        try {
            $user->register();
                $details = [
                    'subject' => 'Verification Code',
                    'title' => 'AtomAP',
                    'code' => $code,
                    'name' => $user->name,
                    'email' => $user->email,
                ];
                Mail::to($user->email)->send(new registrationMail($details));

            DB::commit();
        } catch (\Exception $e) {
            Log::debug($e);
            DB::rollback();
            return response()->json([
                'message' => __('voyager::generic.something_wrong'),
                'id'=>$user->id
            ], 403);
        }
        return response()->json([
            'message' => __('bread.users.model_name') . ' '.__('voyager::generic.successfully_added_new'),
            'user_id' => $user->id
        ], 200);
    }

    public function verifyOtp(Request $request,$id){
        //dd($request);
        /** @var \App\Models\User $authUser */
        /** @var User $dataTypeContent */
        $userDetails=User::where('id',$id)->first();
        if ($userDetails->otp==null){
            return redirect()->route('voyager.login');
        }
        $user_id=$id;
        $view = 'voyager::verify-form';
        $user=User::where('id',$id)->first();
        return Voyager::view($view, compact(
            'user'
        ));
    }
    function verification(Request $request)
    {
        $user = app(User::class);
        $validate = Validator::make($request->all(), [
            'otp' => 'required',
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()->all()], 400);
        }


        $inputs = $request->input();
        $attributes = [
            'otp', 'email'
        ];

        foreach ($inputs as $field => $value) {
            if (in_array($field, $attributes)) {
                $user->{$field} = $value;
            }
        }
        if ($user->email){
            $userDertails=User::where('email',$user->email)->where('otp',$user->otp)->first();
            $user_status=User::where('email',$user->email)->where('status',1)->first();
            if ($userDertails!=null){
                try {
                    User::where('email', $userDertails->email)->update(['status' => 1,'otp'=>NULL]);
                }catch (\Exception $e) {
                    return response()->json([
                        'message' => __('voyager::generic.something_wrong')
                    ], 403);
                }
                return response()->json([
                    'message' => __('bread.users.model_name') . ' ' . __('voyager::generic.successfully_verified')
                ], 200);
            }elseif ($user_status!=null){
                return response()->json([
                    'message' => __('voyager::generic.already_verified'),
                ], 403);
            }else{
                return response()->json([
                    'message' => __('voyager::generic.otp_missmatch'),
                ], 403);
            }

        }else{
            return response()->json([
                'message' => __('voyager::generic.email_invalid')
            ], 403);
        }
    }

    function resendOtp(Request $request)
    {
        $user = app(User::class);
        if ($request->email){
            $userDertails=User::where('email',$request->email)->first();
            if ($userDertails!=null){
                try {
                    $code = str_random(6);
                    User::where('email', $userDertails->email)->update(['otp'=>$code]);
                    $details = [
                        'subject' => 'Verification Code',
                        'title' => 'AtomAP',
                        'code' => $code,
                        'name' => $userDertails->name,
                        'email' => $userDertails->email,
                    ];
                    Mail::to($userDertails->email)->send(new registrationMail($details));
                }catch (\Exception $e) {
                    return response()->json([
                        'message' => __('voyager::generic.something_wrong')
                    ], 403);
                }
                return response()->json([
                    'message' => __('bread.users.model_name') . ' ' . __('voyager::generic.resend_success')
                ], 200);
            }else{
                return response()->json([
                    'message' => __('voyager::generic.email_invalid'),
                ], 403);
            }

        }else{
            return response()->json([
                'message' => __('voyager::generic.email_invalid')
            ], 403);
        }
    }

}
