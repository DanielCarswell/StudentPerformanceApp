<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('admin.index'/*, [
            'accounts' => $accounts
        ]*/);
    }

    public function users()
    {
        $accounts = \DB::table('user_class_models')
        ->select('user_class_models.user_id AS id', 'users.fullname', 'users.email', 'roles.name AS role_name')
        ->from('user_class_models')
        ->join('users', 'users.id', '=', 'user_class_models.user_id')
        ->join('user_role', 'user_role.user_id', '=', 'users.id')
        ->join('roles', 'roles.id', '=', 'user_role.role_id')
        ->where('users.id', '!=', 1)
        ->groupBy('user_class_models.user_id', 'users.fullname', 'users.email', 'role_name')
        ->paginate(8);

        foreach($accounts as $account) {
            $account->acc = User::find($account->id);
        }

        return view('admin.users.index', [
            'accounts' => $accounts
        ]);
    }
}
