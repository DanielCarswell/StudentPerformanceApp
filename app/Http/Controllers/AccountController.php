<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\LowGradeNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    /**
    * Ensures user authentication to access Controller.  
    */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
    * Gets all Accounts and their associated Roles for Accounts.index display.
    *
    * @return view     
    */
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

    /**
    * Passes User details to user edit page.
    *
    * @param \App\Models\User account
    * @return view     
    */
    public function edit(User $account) {
        return view('admin.users.edit', [
            'account' => $account
        ]);
    }

    /**
    * Updates Account Details in Database.
    *
    * @param \Illuminate\Http\Request request
    * @return this.index.method    
    */
    public function update(Request $request) 
    {
        //Checking user credentials are valid.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'firstname' => ['required'],
            'lastname' => ['required']
        ]); 

        //Get email from database.
        $email_acc = DB::table('users')->where('users.email', '=', $request->email)->first();

        //Confirm email is users or modified and does not belong to someone else.
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

    /**
    * Deletes user from database if User is authorized to do so
    * for further methods I limited access to delete methods instead of Authorize Policies.
    *
    * @param \App\Models\User account
    * @return back.to.last.view     
    */
    public function destroy(User $account)
    {
        //Authorize deleting account.
        $this->authorize('delete', auth()->user());   

        //Delete account from database.
        $account->delete();
        return back();
    }

    /**
    * Returns view of a Students Advisors.
    *
    * @param \App\Models\User student
    * @return view     
    */
    public function advisors(User $student) {
        //Get all Advisors currently assigned to Student.
        $advisors = DB::table('users')
        ->join('student_advisor', 'student_advisor.advisor_id', 'users.id')
        ->where('student_advisor.student_id', $student->id)
        ->paginate(10);

        return view('accounts.advisors', [
            'student' => $student,
            'advisors' => $advisors
        ]);
    }

    /**
    * Filters available Advisors not yet allocated to Student
    * and passes them to a page to Add Advisors for student.
    *
    * @param \App\Models\User student
    * @return view     
    */
    public function add_advisor(User $student) {
        //Initializing local variable.
        $ids = [];

        //Getting all Advisor ids assigned to Student.
        $advisors = DB::table('users')
        ->select('users.id')
        ->from('users')
        ->join('student_advisor', 'student_advisor.advisor_id', '=', 'users.id')
        ->where('student_advisor.student_id', $student->id)
        ->get();

        //Add id's to array for whereNotIn query to filter out already assigned Advisors.
        foreach($advisors as $advisor)
            array_push($ids, $advisor->id);

        //Get All Available Advisors not already Assigned to Student.
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

    /**
    * Adds Advisor for the Student to Database.
    *
    * @param int student_id
    * @param int advisor_id
    * @return route.redirect 
    */
    public function advisor_add(int $student_id, int $advisor_id) {
        //Associate Student and Advisor in Database.
        DB::table('student_advisor')
        ->insert(['student_id' => $student_id, 'advisor_id' => $advisor_id]);

        //Get student model for View.
        $student = User::find($student_id);

        return redirect()->route('student.advisors', $student);
    }

    /**
    * Deletes Advisor and Student relationship from Database.
    *
    * @param 
    * @return route.redirect     
    */
    public function delete_advisor(int $student_id, int $advisor_id) {
        //Where Advisor and Student ids match on student advisor table
        //delete the table row.
        DB::table('student_advisor')
        ->where('advisor_id', $advisor_id)
        ->where('student_id', $student_id)
        ->delete();

        //Get student model for View.
        $student = User::find($student_id);

        return redirect()->route('student.advisors', $student);
    }

    /**
    * Filter available Advisors to find a specific name.
    *
    * @param \Illuminate\Http\Request request
    * @return view     
    */
    public function search_advisors(Request $request) {
        //initialize local variables.
        $q = $request->q;
        $ids = [];

        //Get advisor_ids for Advisors of the Student.
        $advisor_ids = DB::table('users')
        ->select('users.id')
        ->from('users')
        ->join('student_advisor', 'student_advisor.advisor_id', '=', 'users.id')
        ->where('student_advisor.student_id', $request->student_id)
        ->get();

        //Adds ids to Array for WhereNotIn.
        foreach($advisor_ids as $id)
            array_push($ids, $id->id);

        //Search for all advisors with fullname like query input.
        $advisors = DB::table('users')
        ->select('users.id', 'users.fullname')
        ->from('users')
        ->join('student_advisor', 'student_advisor.advisor_id', '=', 'users.id')
        ->where( 'users.fullname', 'LIKE', '%' . $q . '%' )
        ->whereNotIn('users.id', $ids)
        ->distinct()
        ->paginate(8);

        //Get student model for View.
        $student = User::find($request->student_id);

        return view('accounts.add_advisor', [
            'student' => $student,
            'advisors' => $advisors
        ]);
    }
}
