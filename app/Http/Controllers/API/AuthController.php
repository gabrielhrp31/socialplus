<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

    public function register(Request $request){
        $data = $request->all();

        $validation = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if($validation->fails()){
            return $validation->errors();
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->token = $user->createToken($user->email)->accessToken;

        return $user;
    }

    public function login(Request $request){
        $data = $request->all();

        $validation = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255',],
            'password' => ['required', 'string'],
        ]);

        if($validation->fails()){
            return $validation->errors();
        }

        if(Auth::attempt(['email'=> $data['email'], 'password'=> $data['password'],])){
            $user = auth()->user();

            $user->token = $user->createToken($user->email)->accessToken;
            return $user;
        }else{
            return ['code' => 400,'message'=>'Email ou Senha Incorretos!'];
        }
    }

    public function checkLogin(Request $request){
        return ["status"=>true];
    }
}