<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Models\UserToken;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Register new user
     * @param  RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request)
    {

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'specialist' => $request->specialist,
            'birthday' => $request->birthday,
            'status' => $request->status,
            'type' => $request->type,
            'address' => $request->address,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('Token-Login')->accessToken;

        $user->update(['remember_token' => $token]);


        return $this->respondWithItem(new UserResource($user));
    }

    /**
     * Login
     * @param  LoginRequest $request
     * @return mixed
     */
    public function login(LoginRequest $request)
    {

        if (!Auth::attempt($request->only('email', 'password'))) {

            return $this->errorStatus(__('Unauthorized'));
        }
        $user = Auth::user();

        $oldUser = User::where('device_token', $request->device_token)->get();
      
        if ($oldUser) {
         User::where('device_token', $request->device_token)
         ->where('email','!=',$request->email)->update([
            'device_token' => 0,
         ]);

          
        }
        $token = $user->createToken('Token-Login')->accessToken;

        $user->update([
            'remember_token' => $token,
            'device_token' => $request->device_token,
        ]);

        return $this->respondWithItem(new UserResource($user));
    }

    public function show(Request $request)
    {
        $user = User::find($request->user_id);

        return $this->respondWithItem(new UserResource($user));
    }
}
