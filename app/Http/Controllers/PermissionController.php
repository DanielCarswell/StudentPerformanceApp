<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Role;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index() {
        $permissions = DB::table('permissions')->paginate(20);

        return view('admin.permissions.index', [
            'permissions' => $permissions
        ]);
    }

    public function add_role_permission(Request $request) {
        $permission_id = Permission::where('name', '=', $request->permission)->first()->id;

        DB::table('role_permission')
        ->insert(['role_id' => $request->role_id, 'permission_id' => $permission_id]);

        $role = Role::find($request->role_id);
        return $this->role_permissions($role);
    }

    public function role_permissions(Role $role) {
        $permissions = DB::table('permissions')
        ->select('permissions.id', 'permissions.name', 'permissions.slug')
        ->from('permissions')
        ->join('role_permission', 'role_permission.permission_id', '=', 'permissions.id')
        ->join('roles', 'role_permission.role_id', '=', 'roles.id')
        ->where('roles.id', '=', $role->id)
        ->paginate(20);

        return view('admin.permissions.role_permissions', [
            'permissions' => $permissions,
            'role' => $role
        ]);
    }

    public function delete(int $role_id, int $permission_id) {
        DB::table('role_permission')
        ->where('role_id', $role_id)
        ->where('permission_id', $permission_id)
        ->delete();

        $role = Role::find($role_id);

        return $this->role_permissions($role);
    }
}
