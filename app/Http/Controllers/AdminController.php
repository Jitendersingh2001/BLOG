<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class AdminController extends Controller
{
    public function getUsers()
    {
        $adminRole = Role::where('role', Role::ADMIN)->first();
        $adminUser = $adminRole->user;
        return response()->json(['AdminUser' => $adminUser]);
    }
}
