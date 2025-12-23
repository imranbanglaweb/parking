<?php

namespace App\Http\Controllers\Api;

use App\Models\FieldSupervisor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseApiController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->sendResponse($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return $this->sendResponse("", 'Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('api');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            $this->username() => 'required|string|min:4|unique:field_supervisors,' . $this->username(),
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password',
            'cell_phone' => 'regex:/^01[1-9][0-9]{9}$/'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = FieldSupervisor::create([
            $this->username() => $request->get($this->username()),
            'password' => $request->password,
            'full_name' => $request->full_name,
            'cell_phone' => $request->cell_phone,
            'activation_status' => 1,
            'activated_at' => Carbon::now('Asia/Dhaka')->format('Y-m-d'),
        ]);

        $token = $this->guard()->login($user);

        return $this->respondWithToken($token);
    }

    public function login()
    {
        $credentials = request([$this->username(), 'password']);

        $validator = Validator::make($credentials, [
            $this->username() => 'required|string|min:4',
            'password' => 'required|min:4',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if (!$token = $this->guard()->attempt($credentials)) {
            return $this->sendError('Unauthorized', 'Invalid Login Credentials', 401);
        }

        return $this->respondWithToken($token);
    }

    public function getHi()
    {
        return $this->sendResponse(request()->all(), 'Success');
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }
}
