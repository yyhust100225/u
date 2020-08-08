<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends CommonController
{

    public function list(Request $request, User $user)
    {

    }

    public function users(Request $request, User $user)
    {
        // $users = $user->all();

        $attributes = [
            'username' => 'huorui',
            'email' => 'youy327920@163.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'remember_token' => Str::random(10),
        ];

        $user = $user->where('username', 'huorui')->firstOrNew($attributes);

        dd($user->toArray());
    }
}
