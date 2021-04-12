<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class First extends Controller
{
    public function __invoke(Request $request)
    {
//        $role = Role::create(['name' => 'writer']);
//        $permission = Permission::create(['name' => 'edit articles']);
//        $role->givePermissionTo($permission);
//        auth()->user()->assignRole($role);
        dd(auth()->user()->getAllPermissions());
        dd(auth()->user()->getRoleNames());
    }
}
