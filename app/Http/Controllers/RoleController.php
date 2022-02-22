<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::with(['permissions'])
        ->paginate(8);

        return view('admin.roles.index', [
            'roles' => $roles
        ]);
    }

    public function add_role_permission(Role $role) {
        $permissions = Permission::all();
        return view('admin.roles.add_role_permission', [
            'permissions' => $permissions,
            'role' => $role
        ]);
    }

    public function add(Request $request) {
        //Checking assignment credentials are valid.
        $credentials = $request->validate([
            'rolename' => ['required', 'max:255']
        ]); 

        //Adding role to database if valid credentials.
        if ($credentials) {
            DB::table('roles')->insert([
                'name' => $request->rolename
            ]);
        }

        return $this->index();
    }

    public function create() {
        return view('admin.roles.create_role');
    }

    public function edit(Role $role) {
        return view('admin.roles.edit', [
            'role' => $role
        ]);
    }

    public function modify(Request $request) {
        $credentials = $request->validate([
            'rolename' => ['required', 'max:255', 'unique:roles']
        ]); 

        //Adding role to database if valid credentials.
        if ($credentials) {
            DB::table('roles')
            ->where('roles.id', '=', $request->roles_id)
            ->update([
                'name' => $request->rolename
            ]);
        }

        return $this->index();
    }

    public function delete(Role $role) {
        return view('admin.roles.delete', [
            'role' => $role
        ]);
    }

    public function destroy(Role $role) {
        $this->authorize('delete_role', auth()->user());   
        $role->delete();
        
        $roles = Role::with(['permissions'])
        ->paginate(8);

        return view('admin.classes.index', [
            'classes' => $classes
        ]);
    }

    public function search_roles(Request $request) {
        $query = $request->q;

        $roles = Role::where('name', 'LIKE', '%' . $query . '%')
        ->paginate(5);

        return view('admin.roles.index', [
            'roles' => $roles
        ]);
    }
}
