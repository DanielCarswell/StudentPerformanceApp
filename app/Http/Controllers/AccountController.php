<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\LowGradeNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $accounts = \DB::table('user_class')
        ->select('user_class.user_id AS id', 'users.fullname', 'users.email', 'roles.name AS role_name')
        ->from('user_class')
        ->join('users', 'users.id', '=', 'user_class.user_id')
        ->join('user_role', 'user_role.user_id', '=', 'users.id')
        ->join('roles', 'roles.id', '=', 'user_role.role_id')
        ->where('users.id', '!=', 1)
        ->groupBy('user_class.user_id', 'users.fullname', 'users.email', 'role_name')
        ->paginate(8);

        foreach($accounts as $account) {
            $account->acc = User::find($account->id);
        }

        //Mail::to(auth()->user())->send(new LowGradeNotification(auth()->user(), 'CS103'));

        return view('accounts.index', [
            'accounts' => $accounts
        ]);
    }

    public function show(User $account)
    {
        return view('accounts.show', [
            'account' => $account
        ]);
    }

    public function update(User $account)
    {
        //
    }

    public function destroy(User $account)
    {
        
        $this->authorize('delete', auth()->user());
        
        $account->delete();

        return back();
    }
}
