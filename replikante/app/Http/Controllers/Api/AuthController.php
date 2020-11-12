<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        
        $credentials = $request->only(['email', 'password']);
        //$token = \JWTAuth::attempt($credentials);

        $authDataBase = User::where('email', $request->email)->where('status', '1')->first();
        if(!$authDataBase){
            return response()->json(['status' => 'Usuário desabilitado'], 403);
        }

        //return response()->json(['token' => $token]);


        //if($token = \JWTAuth::attempt($credentials)){

        //dd(bcrypt($request->password));

        //$token = auth()->attempt($credentials);

        
        if($token = JWTAuth::attempt($credentials)){ 
            return $this->respondWithToken($token);

        }

        return response()->json(['error' => 'Unauthorized']);
    }

    protected function respondWithToken($token){
        return response()->json([
            'name'         => auth()->user()->name,
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 3600
        ]);
    }
}
