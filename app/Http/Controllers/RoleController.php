<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RoleController extends Controller
{
    public function index($id)
    {
        $user = User::findOrFail($id);
        $roles = $user->roles;

        return response()->json($roles);
    }
}