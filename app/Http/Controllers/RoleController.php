<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Role;

class RoleController extends Controller
{
    /**
    * Ensures user authentication to access Controller.  
    */
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    /**
    *
    * @param 
    * @return view     
    */
    public function index() {
        $roles = Role::get();

        return view('admin.roles.index', [
            'roles' => $roles
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function user_roles(int $user_id) {
        $roles = DB::table('roles')
        ->select('roles.id', 'roles.name')
        ->from('roles')
        ->join('user_role', 'roles.id', '=', 'user_role.role_id')
        ->join('users', 'users.id', '=', 'user_role.user_id')
        ->where('users.id', $user_id)
        ->get();

        $user = User::find($user_id);

        return view('admin.roles.user_index', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
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

    /**
    *
    * @param 
    * @return view     
    */
    public function create() {
        return view('admin.roles.create_role');
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function edit(Role $role) {
        if($role->id < 9)
            return back();
        return view('admin.roles.edit', [
            'role' => $role
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function modify(Request $request) {
        if($role->id < 9)
            return back();
        if ($request->name != $request->original) {
            DB::table('roles')
            ->where('roles.id', '=', $request->role_id)
            ->update([
                'name' => $request->name
            ]);

            return $this->index();
        }

        $role = Role::find($request->role_id);
        $roles = Role::get();
        
        foreach($roles as $role)
        {
            if($role->name == $request->name)
                return view('admin.roles.edit', [
                'role' => $role
            ])->withErrors([
                'name' => 'Role name already exists.'
            ]);
        }
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function delete(Role $role) {
        if($role->id < 9)
            return back();
        $role->delete();
        return back();
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function remove(Request $request) {
        DB::table('user_role')
        ->where('role_id', $request->role_id)
        ->where('user_id', $request->user_id)
        ->delete();

        return back();
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function give(User $user) {
        $roles = DB::table('roles')
        ->get();

        return view('admin.roles.give_role', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function give_role(Request $request) {
        //Checking circumstance credentials are valid.
        $credentials = $request->validate([
            'role' => ['required', 'max:255']
        ]); 

        if($request->role == "Select Role")
                return back()->withErrors([
                    'role' => 'Please select a role.'
                ]);

        $role = Role::with(['users'])->where('name', $request->role)->first();

        $roles = DB::table('roles')
        ->select('roles.id', 'roles.name')
        ->from('roles')
        ->join('user_role', 'user_role.role_id', '=', 'roles.id')
        ->where('user_role.user_id', $request->user_id)
        ->get();

        foreach($roles as $role1)
            if($role1->id == $role->id)
                return back()->withErrors([
                    'role' => 'This role is already assigned to the user.'
                ]);
        
        if ($credentials) {
            DB::table('user_role')->insert([
                'user_id' => $request->user_id,
                'role_id' => $role->id
            ]);
        }
        return redirect()->route('user_roles', $request->user_id);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function destroy(Role $role) {
        if($role->id < 9)
            return back();
        $this->authorize('delete_role', auth()->user());   
        $role->delete();
        
        $roles = Role::paginate(8);

        return view('admin.classes.index', [
            'classes' => $classes
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function search_roles(Request $request) {
        $query = $request->q;

        $roles = Role::where('name', 'LIKE', '%' . $query . '%')
        ->paginate(5);

        return view('admin.roles.index', [
            'roles' => $roles
        ]);
    }
}
