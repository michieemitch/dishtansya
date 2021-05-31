<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UsersResource;
use Laravel\Passport\HasApiTokens;
use App\Models\User;
class AuthController extends Controller
{
    public function login()
    {
    	try {
			$try = 0;
    		if (Auth::attempt(['email' =>  request('email'), 'password' => request('password')])) {

				if (User::where('email', request('email'))->exists()) {
					$try += 1;

					$Userdata = User::where('email', request('email'))->first();
                    $updUser = User::find($Userdata->id);
					if($updUser->locked == 1){
						return response()->json(['message' => 'Account has been locked due to 5 failed attempts'], 401);
					}

				}

		        $user = Auth::user();
				$data['token'] =  $user->createToken('dishtansya')->accessToken;
				$user->update();
				$data['user'] = new UsersResource($user);
		        // return response()->json(['data' => $data], 200);
                return response()->json(['access_token' => $data['token']], 201);
		    }else{
				if (User::where('email', request('email'))->exists()) {

					$Userdata = User::where('email', request('email'))->first();
					$updUser = User::find($Userdata->id);

					if($updUser->failed_attempts == 5){
						$updUser->locked = 1;
						$updUser->failed_attempts = 0;
						$updUser->save();
	
						return response()->json(['message' => 'Account has been locked due to 5 failed attempts'], 401);
					}else if($updUser->locked == 1){
						return response()->json(['message' => 'Account has been locked due to 5 failed attempts'], 401);
					}else{
						$try += 1;
						$updUser->failed_attempts += $try;
						$updUser->save();
					}
					

				}

				
				
				return response()->json(['message' => 'Invalid credentials'], 401);
			}
		    

    	} catch (\Exception $e) {
    		return response()->json(['message' => $e->getMessage()], 500);
    	}
	}
	
	public function logout() {
		if (Auth::check()) {
			Auth::user()->AauthAcessToken()->delete();
		}
		return response()->json('Successfully logged out');
	}
}
