<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

// hamada テスト2
class UserController extends Controller
{

    public function userList(Request $request)
    {
        $users = User::all();

        return response()->json(['users' => $users]);
    }

    public function userCreate(Request $request)
    {
        $user = User::create($request->user);
        return response()->json(['user' => $user]);
    }

    public function userDetail(User $user)
    {
        return response()->json(['user' => $user]);
    }

    public function userEdit(User $user, Request $request)
    {
        $user->update($request->user);
        return response()->json(['user' => $user]);
    }
  
    public function userDelete(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'delete successfully']);
    }      
}
