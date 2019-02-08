<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transformers\UserTransformer;
Use Auth;
class UserController extends Controller
{
    public function users(User $user){
        $users = User::all();

        return fractal()
            ->collection($users)
            ->transformWith(new UserTransformer)
            ->toArray();
    }
    public function profile(User $user){
        $user = User::find(Auth::user()->id);

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();
    }
}
