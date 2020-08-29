<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends CommonController
{

    public function list(Request $request, User $user)
    {
        return view('admin.user.users');
    }

    public function data(Request $request, User $user)
    {
        $users = $user->data($request->input('page'), $request->input('limit'));
        $count = $user->num();

        foreach($users as $user) {
            $user->role;
        }

        return response()->json([
            'code' => RESPONSE_SUCCESS,
            'msg' => trans('request.success'),
            'count' => $count,
            'data' => $users,
        ], 200);
    }
}
