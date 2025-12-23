<?php


namespace App\Http\Controllers\Api;


use App\Models\ApiPasswordReset;
use App\Models\FieldSupervisor;
use App\Notifications\PasswordResetRequestForApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class PasswordResetController extends BaseApiController
{
    /** Create token password reset
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            $this->username() => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = FieldSupervisor::where($this->username(), $request->get($this->username()))->first();
        if (!$user) {
            return $this->sendError("Not Found", [
                'message' => 'We can\'t find a api user with that ' . $this->username()
            ], 404);
        }

        $passwordReset = ApiPasswordReset::updateOrCreate(
            [$this->username() => $request->get($this->username())],
            [
                $this->username() => $request->get($this->username()),
                'token' => Str::random(60)
            ]
        );

        if (!$passwordReset) {
            return $this->sendError("Opps! Problem!", [
                'message' => 'There was a problem during reset password token generation. Please try again later.'
            ], 400);
        }

        $user->notify(
            new PasswordResetRequestForApi($passwordReset->token)
        );

        return response()->json([
            'message' => 'We have e-mailed your password reset link!'
        ]);
    }

    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = ApiPasswordReset::where('token', $token)->first();

        if (!$passwordReset) {
            return view('api.passwordreset.reset', ['error' => __("Token was not found!")]);
        }

        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return view('api.passwordreset.reset', ['error' => __("Invalid Token")]);
        }
        return view('api.passwordreset.reset', ['token' => $token]);
    }

    /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            $this->username() => 'required|string|min:4',
            'password' => 'required|string|min:4|confirmed',
            'token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->route('api_user_password_reset', ['token' => $request->token])
                ->withErrors($validator)
                ->withInput();
        }

        /** @var ApiPasswordReset $passwordReset */
        $passwordReset = ApiPasswordReset::where([
            ['token', $request->token],
            ['username', $request->get($this->username())]
        ])->first();

        if (!$passwordReset) {
            return redirect()->route('api_user_password_reset', ['token' => $request->token])
                ->with(['error' => __("Reset token was not found!")])->withInput();
        }

        /** @var FieldSupervisor $user */
        $user = FieldSupervisor::where($this->username(), $request->get($this->username()))->first();
        if (!$user) {
            return redirect()->route('api_user_password_reset', ['token' => $request->token])
                ->with(['error' => __("User was not found!")])->withInput();
        }

        try {
            DB::beginTransaction();
            $user->password = $request->password;
            $user->save();
            $passwordReset->delete();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return redirect()->route('api_user_password_reset', ['token' => $request->token])
                ->with(['error' => __("Problem in resetting the password. Please try again later!")])->withInput();
        }

        return view('api.passwordreset.success', ['message' => 'success']);
    }
}
