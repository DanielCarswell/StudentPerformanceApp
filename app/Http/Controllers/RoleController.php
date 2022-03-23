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
    * Get all Roles for a certain User.
    *
    * @param int user_id
    * @return view     
    */
    public function user_roles(int $user_id) {
        //Get all roles for user.
        $roles = DB::table('roles')
        ->select('roles.id', 'roles.name')
        ->from('roles')
        ->join('user_role', 'roles.id', '=', 'user_role.role_id')
        ->join('users', 'users.id', '=', 'user_role.user_id')
        ->where('users.id', $user_id)
        ->get();

        //Get user model for view.
        $user = User::find($user_id);

        return view('admin.roles.user_index', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
    * Remove role from user.
    *
    * @param \Illuminate\Http\Request request
    * @return back.to.previous.view     
    */
    public function remove(Request $request) {
        //Delete role and user association.
        DB::table('user_role')
        ->where('role_id', $request->role_id)
        ->where('user_id', $request->user_id)
        ->delete();

        return back();
    }

    /**
    * Returns add role to user view.
    *
    * @param \App\Models\User user
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
    * Gives role to user if valid.
    *
    * @param \Illuminate\Http\Request request
    * @return view     
    */
    public function give_role(Request $request) {
        //Checking role credentials are valid.
        $credentials = $request->validate([
            'role' => ['required', 'max:255']
        ]); 

        //Check user has actually selected a role.
        if($request->role == "Select Role")
                return back()->withErrors([
                    'role' => 'Please select a role.'
                ]);

        //Get role from database with associated users.
        $role = Role::with(['users'])->where('name', $request->role)->first();

        //Get all roles associated with user.
        $roles = DB::table('roles')
        ->select('roles.id', 'roles.name')
        ->from('roles')
        ->join('user_role', 'user_role.role_id', '=', 'roles.id')
        ->where('user_role.user_id', $request->user_id)
        ->get();

        //Confirm user does not already have role or display error.
        foreach($roles as $role1)
            if($role1->id == $role->id)
                return back()->withErrors([
                    'role' => 'This role is already assigned to the user.'
                ]);
        

        //Add role to user in Database.
        if ($credentials) {
            DB::table('user_role')->insert([
                'user_id' => $request->user_id,
                'role_id' => $role->id
            ]);
        }
        return redirect()->route('user_roles', $request->user_id);
    }
}
