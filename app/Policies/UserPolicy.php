<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user)
    {
        $user_role = \DB::table('user_role')
        ->select('roles.name')
        ->from('user_role')
        ->join('users', 'users.id', '=', 'user_role.user_id')
        ->join('roles', 'roles.id', '=', 'user_role.role_id')
        ->where('users.id', '=', $user->id)
        ->get();

        foreach($user_role as $role_name) {
            if($role_name->name === 'Admin')
                return true;
        }

        return false;
    }
}
