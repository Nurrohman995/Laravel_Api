<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\User;
Use App\Transformers\UserTransformer;
use Auth;
class AuthController extends Controller
{
    public function register(Request $request, User $user){
        $this->validate($request,[
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6",
        ]);

        $user = $user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'api_token' => bcrypt($request->email),
        ]);
        $response = fractal()
            ->item($user)
            ->TransformWith(new UserTransformer)
            ->addMeta([
                'token' => $user->api_token,
            ])
            ->toArray();

        return response()->json($response, 201);
    }
    public function Login(Request $request, User $user)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['error' =>'Maaf Tidak Bisa Login'],401);
        }
        $user = User::find(Auth::user()->id);
        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->addMeta([
                'token' => $user->api_token,
            ])
            ->toArray();
    }
}
