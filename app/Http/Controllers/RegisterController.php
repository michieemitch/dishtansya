<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UsersResource;
use DB;

class RegisterController extends Controller
{
    public function register(Request $request){

        DB::beginTransaction();
		try {

            if(!request('email') || !request('password')){
                return response()->json(['message' => 'All fields are required.'], 404);
            }

            if (User::where('email', request('email'))->exists()) {
                return response()->json(['message' => "Email already taken"],400);
            }

    		$User = new User();
			$User->name = request('name');
			$User->email  = request('email');
			$User->password  = bcrypt(request('password'));
            
			$User->save();

			DB::commit();
		    // return new UsersResource($User);
            return response()->json(['message' => 'User successfully registered'], 201);
    	} catch (\Exception $e) {
			DB::rollback();
			return response()->json(['message' => $e->getMessage()], 400);
    	}

        
    }
}
