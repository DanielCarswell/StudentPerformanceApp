<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Role;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function role_permissions(Role $role) {
        $permissions = DB::table('permissions')
        ->select('permissions.name', 'permissions.slug')
        ->from('permissions')
        ->join('roles', 'roles.id', '=', 'permissions.id')
        ->where('roles.id', '=', $role->id)
        ->paginate(20);

        return view('admin.permissions.role_permissions', [
            'permissions' => $permissions,
            'role' => $role
        ]);
    }
}
