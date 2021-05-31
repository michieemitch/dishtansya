<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UsersResource;
use DB;
use Mail;

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

			$email = request('email');
			$pass = request('password');
			$this->sendUserCredentials($email, $pass);

			DB::commit();
		    // return new UsersResource($User);
            return response()->json(['message' => 'User successfully registered'], 201);
    	} catch (\Exception $e) {
			DB::rollback();
			return response()->json(['message' => $e->getMessage()], 400);
    	}

        
    }

	public function sendUserCredentials($email, $pass){
		// $email = 'michelleapacible10@gmail.com';
		// $pass = 'asd';
		$details = array(
		  "title" => "User Credentials",
		  "email" => $email,
		  "password" => $pass,
		);
  
		Mail::to($email)->send(new \App\Mail\SendMail($details));
		return response()->json(['message' => "Email has ben sent!"]);
  
	  }

}
