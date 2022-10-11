<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class RegisterController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'firstname'=>'required|string',
            'surname'=>'required|string',
            'company_name'=>'required|string',
            'mobile_code'=>'required|string',
            'mobile_no'=>'required|string',
            'address'=>'required|string',
            'email'=>'required|string|unique:tbl_users,email',
            'password' =>'required|string',
        ]);

        $user = User::create([
            'firstname'=>$fields['firstname'],
            'surname'=>$fields['surname'],
            'company_name'=>$fields['company_name'],
            'mobile_code'=>$fields['mobile_code'],
            'mobile_no'=>$fields['mobile_no'],
            'address'=>$fields['address'],
            'email'=>$fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('Register New User')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('Login')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
   
}
