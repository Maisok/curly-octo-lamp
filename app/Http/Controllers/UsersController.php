<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function allusers(){
        $users1=Cache::remember('users', 5, function () { 
            $users = User::all();
            return response()->json($users);;
         });
    }

    
}
