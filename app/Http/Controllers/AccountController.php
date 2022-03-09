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
        $accounts = \DB::table('users')
        ->select('users.id AS id', 'users.fullname', 'users.email', 'roles.name AS role_name')
        ->from('users')
        ->join('user_role', 'user_role.user_id', '=', 'users.id')
        ->join('roles', 'roles.id', '=', 'user_role.role_id')
        ->where('users.id', '!=', 1)
        ->groupBy('users.id', 'users.fullname', 'users.email', 'role_name')
        ->paginate(8);

        foreach($accounts as $account) {
            $account->acc = User::find($account->id);
        }

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

    public function edit(User $account) {
        return view('admin.users.edit', [
            'account' => $account
        ]);
    }

    public function update(Request $request) 
    {
        //Checking user credentials are valid.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'firstname' => ['required'],
            'lastname' => ['required']
        ]); 

        $email_acc = \DB::table('users')->where('users.email', '=', $request->email)->first();

        if($email_acc) {
            if($request->email != $email_acc->email) {}
            else return back()->withErrors([
                'email' => 'The email entered is already registered to another user.'
            ]);
        }

        //Adding new account details to database if valid credentials.
        if ($credentials) {
            \DB::table('users')
            ->where('users.id', '=', $request->user_id)
            ->update([
                'email' => $request->email,
                'username' => substr($request->firstname, 0) . ' ' . substr($request->lastname, 0) . rand(10000, 99999),
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'fullname' => $request->firstname . ' ' . $request->lastname
            ]);
        }

        //return user index
        return $this->index();
    }

    public function destroy(User $account)
    {
        $this->authorize('delete', auth()->user());   
        $account->delete();
        return back();
    }
}
