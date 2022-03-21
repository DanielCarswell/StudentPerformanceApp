<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\LowGradeNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $accounts = DB::table('users')
        ->select('users.id AS id', 'users.fullname', 'users.email', 'roles.name AS role_name')
        ->from('users')
        ->join('user_role', 'user_role.user_id', '=', 'users.id')
        ->join('roles', 'roles.id', '=', 'user_role.role_id')
        ->where('users.id', '!=', 1)
        ->groupBy('users.id', 'users.fullname', 'users.email', 'role_name')
        ->paginate(8);

        foreach($accounts as $account) {
            $account->acc = User::find($account->id);

            $account->roles = DB::table('roles')
            ->join('user_role', 'roles.id', '=', 'user_role.role_id')
            ->join('users', 'users.id', '=', 'user_role.user_id')
            ->where('users.id', $account->id)
            ->get();
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

    public function student_accounts() {
        return view('accounts.student_accounts');
    }

    public function update(Request $request) 
    {
        //Checking user credentials are valid.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'firstname' => ['required'],
            'lastname' => ['required']
        ]); 

        $email_acc = DB::table('users')->where('users.email', '=', $request->email)->first();

        if($email_acc) {
            if($request->email != $email_acc->email) {}
            else return back()->withErrors([
                'email' => 'The email entered is already registered to another user.'
            ]);
        }

        //Adding new account details to database if valid credentials.
        if ($credentials) {
            DB::table('users')
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

    public function advisors(User $student) {
        $advisors = DB::table('users')
        ->join('student_advisor', 'student_advisor.advisor_id', 'users.id')
        ->where('student_advisor.student_id', $student->id)
        ->paginate(10);

        return view('accounts.advisors', [
            'student' => $student,
            'advisors' => $advisors
        ]);
    }

    public function add_advisor(User $student) {
        $ids = [];

        $advisors = DB::table('users')
        ->select('users.id')
        ->from('users')
        ->join('student_advisor', 'student_advisor.advisor_id', '=', 'users.id')
        ->join('user_role', 'user_role.user_id', '=', 'users.id')
        ->join('roles', 'user_role.role_id', '=', 'roles.id')
        ->where('student_advisor.student_id', $student->id)
        ->where('roles.name', 'Advisor')
        ->get();

        foreach($advisors as $advisor)
            array_push($ids, $advisor->id);

        $advisors = DB::table('users')
        ->select('users.id', 'users.fullname')
        ->from('users')
        ->join('user_role', 'user_role.user_id', '=', 'users.id')
        ->join('roles', 'user_role.role_id', '=', 'roles.id')
        ->where('roles.name', 'Advisor')
        ->whereNotIn('users.id', $ids)
        ->paginate(10);

        return view('accounts.add_advisor', [
            'student' => $student,
            'advisors' => $advisors
        ]);
    }

    public function advisor_add(int $student_id, int $advisor_id) {
        DB::table('student_advisor')
        ->insert(['student_id' => $student_id, 'advisor_id' => $advisor_id]);

        $student = User::find($student_id);

        return redirect()->route('student.advisors', $student);
    }

    public function delete_advisor(int $student_id, int $advisor_id) {
        DB::table('student_advisor')
        ->where('advisor_id', $advisor_id)
        ->where('student_id', $student_id)
        ->delete();

        $student = User::find($student_id);

        return redirect()->route('student.advisors', $student);
    }

    public function search_advisors(Request $request) {
        $q = $request->q;
        $ids = [];

        $advisor_ids = DB::table('users')
        ->select('users.id')
        ->from('users')
        ->join('student_advisor', 'student_advisor.advisor_id', '=', 'users.id')
        ->where('student_advisor.student_id', $request->student_id)
        ->where( 'users.fullname', 'LIKE', '%' . $q . '%' )
        ->get();

        foreach($advisor_ids as $id)
            array_push($ids, $id->id);

        $advisors = DB::table('users')
        ->select('users.id', 'users.fullname')
        ->from('users')
        ->join('student_advisor', 'student_advisor.advisor_id', '=', 'users.id')
        ->where( 'users.fullname', 'LIKE', '%' . $q . '%' )
        ->whereNotIn('users.id', $ids)
        ->distinct()
        ->paginate(8);

        $student = User::find($request->student_id);

        return view('accounts.add_advisor', [
            'student' => $student,
            'advisors' => $advisors
        ]);
    }
}
