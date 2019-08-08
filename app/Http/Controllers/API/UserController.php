<?php

namespace App\Http\Controllers\API;

use http\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{


    public function update(Request $request){
        $user = $request->user();
        $data = $request->all();

        if(isset($data['password'])){
            $validation = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255',Rule::unique('users')->ignore($user->id)],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            if($validation->fails()){
                return $validation->errors();
            }

            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);

        }else{
            $validation = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255',Rule::unique('users')->ignore($user->id)],
            ]);

            $user->name = $data['name'];
            $user->email = $data['email'];
        }



        if(isset($data['image'])){
            $time = time();
            $root = 'profile';
            $imageFolder = $root.DIRECTORY_SEPARATOR.'user'.$user->id;
            $ext = substr($data['image'], 11, strpos($data['image'],';')-11);
            $imageURL = $imageFolder.DIRECTORY_SEPARATOR.$time.'.'.$ext;

            $file = str_replace('data:image/'.$ext.';base64,','',$data['image']);
            $file = base64_decode($file);

            $amazonUrl = str_replace(DIRECTORY_SEPARATOR, '/',
                str_replace('https://' . env('AWS_BUCKET') . '.s3.amazonaws.com/','',$user->image));


                $result = Storage::disk('s3')->exists($amazonUrl);

            if($result){
                Storage::disk('s3')->delete($amazonUrl);
            }

            if(!$result){
                Storage::disk('s3')->put($imageURL, $file, 'public');
            }

            $user->image = $imageURL;

        }


        $user->save();

        $user->token = $user->createToken($user->email)->accessToken;

        return $user;
    }
}
