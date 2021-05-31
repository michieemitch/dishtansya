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

    		if (Auth::attempt(['email' =>  request('email'), 'password' => request('password')])) {

		        $user = Auth::user();
				$data['token'] =  $user->createToken('dishtansya')->accessToken;
				$user->update();
				$data['user'] = new UsersResource($user);
		        // return response()->json(['data' => $data], 200);
                return response()->json(['access_token' => $data['token']], 201);
		    }
		    return response()->json(['message' => 'Invalid credentials'], 401);

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
