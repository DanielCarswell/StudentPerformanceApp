<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Role;

class RoleController extends Controller
{
    public function index() {
        $roles = Role::with(['permissions'])
        ->paginate(8);

        return view('admin.roles.index', [
            'roles' => $roles
        ]);
    }

    public function create() {
        
    }

    public function edit(Role $role) {
        return view('admin.roles.edit', [
            'role' => $role
        ]);
    }

    public function update(Request $request) {
        
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
