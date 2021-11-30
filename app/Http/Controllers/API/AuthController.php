<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;




class AuthController extends Controller
    
{
    public function register(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'username'=>'required|max:255|unique:users,username',
            'email'=>'required|email|max:255|unique:users,email',
            'password'=>'required|min:8',
            'confirm_password'=>'required|min:8|same:password',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }
        else{
            $user = User::create([
                'username'=>$request->username,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),

            ]);
  


            if($user->role_as==2) ///nhanvien
            {
                $token=$user->createToken($user->email.'_Admintoken',['server:admin'])->plainTextToken;
            }
            else if($user->role_as==1) //admin
            {
                $token=$user->createToken($user->email.'_Personneltoken',['server:personnel'])->plainTextToken;

            } 
            else{
                $token=$user->createToken($user->email.'_token',[''])->plainTextToken;
            }
           
            return response()->json([
                'status'=>200,
                'username'=>$user->username,
                'token'=>$token,
                'message'=>'Registered Successlly',
            ]);


        }

    }

    public function login(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'username'=>'required|max:255',
            'password'=>'required|min:8',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->errors(),
            ]);
        }
        else{


            $user = User::where('username', $request->username)->first();
            if(! $user)
            {
                $user = User::where('email', $request->username)->first();
            }
    
            if (!$user || ! Hash::check($request->password, $user->password)){
                return response()->json([
                    'status'=>401, 
                    'message'=>"invalid Credentials"
                ]);
                
            }
            else{

                if($user->role_as==2) ///admin
                {
                    $token=$user->createToken($user->email.'_Admintoken',['server:admin'])->plainTextToken;
                }
                else if($user->role_as==1) //personnel
                {
                    $token=$user->createToken($user->email.'_Personneltoken',['server:personnel'])->plainTextToken;

                } 
                else{
                    $token=$user->createToken($user->email.'_token',[''])->plainTextToken;
                }
               
                return response()->json([
                    'status'=>200,
                    'username'=>$user->username,
                    'token'=>$token,
                    'message'=>'Login Successlly',
                ]);
            }

        }

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
      return response()->json([
          'status'=>200,
          "message"=>"Logged Out Successfully"
      ]);
    }

    public function user()

    {
        if(auth('sanctum')->check())
        {
            $user=auth('sanctum')->user();
            //   $user=User::where('id', $username)->get();
              return response()->json([
                  'status'=>200,
                  "user"=>$user
              ]);
        }
        else{
            
        }
    
    }
}