<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\Circumstance;
use App\Mail\Circumstances;

class StudentController extends Controller
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
    public function index()
    {
        $students = User::with(['classes'])
        ->join('student_advisor', 'student_advisor.student_id', '=', 'users.id')
        ->where('student_advisor.advisor_id', '=', auth()->user()->id)
        ->paginate(8);

        foreach($students as $student) {
            $student->average_grade = (\DB::table('student_class')
            ->select(\DB::raw('round(AVG(CAST(student_class.grade as numeric)), 1) as average_grade'))
            ->where('student_class.student_id', '=', $student->id)
            ->groupBy('student_class.student_id')
            ->get()[0]->average_grade);

            $student->average_attendance = (\DB::table('student_class')
            ->select(\DB::raw('round(AVG(CAST(student_class.attendance as numeric)), 1) as average_attendance'))
            ->where('student_class.student_id', '=', $student->id)
            ->groupBy('student_class.student_id')
            ->get()[0]->average_attendance);
        }

        return view('students.index', [
            'students' => $students
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function add_circumstance(User $student) {
        $circumstances = DB::table('circumstances')
        ->get();

        return view('students.add_student_circumstance', [
            'student' => $student,
            'circumstances' => $circumstances
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function update_circumstance(Request $request) {
        //Checking circumstance credentials are valid.
        $credentials = $request->validate([
            'circumstance' => ['required', 'max:255']
        ]); 

        $circumstance = Circumstance::with(['circumstance_links'])->where('name', $request->circumstance)->first();

        $student_circumstances = DB::table('circumstances')
        ->select('circumstances.id', 'circumstances.name', 'circumstances.information')
        ->from('circumstances')
        ->join('student_circumstance', 'student_circumstance.circumstance_id', '=', 'circumstances.id')
        ->join('users', 'student_circumstance.student_id', '=', 'users.id')
        ->where('users.id', $request->student_id)
        ->get();

        foreach($student_circumstances as $circumstance1)
            if($circumstance1->id == $circumstance->id)
                return back()->withErrors([
                    'circumstance' => 'This circumstance is already assigned to the Student.'
                ]);
        
         //Adding circumstance to student if valid credentials.
         if ($credentials) {
            DB::table('student_circumstance')->insert([
                'student_id' => $request->student_id,
                'circumstance_id' => $circumstance->id
            ]);
            $student = User::find($request->student_id);

            Mail::to($student->email)->send(new Circumstances($student, $circumstance->name, $circumstance->information, $circumstance->circumstance_links));
        }
            
        $student = User::find($request->student_id);
        return redirect()->route('student.circumstances', $student);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function remove_circumstance(Request $request) {
        //add policy check for restriction
        DB::table('student_circumstance')
        ->where('student_id', $request->student_id)
        ->where('circumstance_id', $request->circumstance_id)
        ->delete();

        return back();
    }

    public function add_note(User $student) {
        return view('students.add_advisor_note', [
            'student' => $student,
            'advisor' => auth()->user()
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function update_note(Request $request) {
        //Checking note credentials are valid.
        $credentials = $request->validate([
            'topic' => ['required', 'max:255'],
            'note' => ['required', 'max:10000']
        ]); 
        
         //Adding note to student if valid credentials.
         if ($credentials) {
            DB::table('student_advisor_notes')->insert([
                'student_id' => $request->student_id,
                'advisor_id' => $request->advisor_id,
                'topic' => $request->topic,
                'note' => $request->note
            ]);
            $student = User::find($request->student_id);
        }
            
        $student = User::find($request->student_id);
        return redirect()->route('student.notes', $student);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function edit_note(Request $request) {
        $student = User::find($request->student_id);

        return view('students.edit_advisor_note', [
            'note' => $request->note,
            'student' => $student,
            'topic' => $request->topic,
            'advisor' => auth()->user()
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function modify_note(Request $request) {
        //Checking note credentials are valid.
        $credentials = $request->validate([
            'topic' => ['required', 'max:255'],
            'note' => ['required', 'max:10000']
        ]);
        if ($credentials) {
            DB::table('student_advisor_notes')
            ->where('student_id', $request->student_id)
            ->where('advisor_id', $request->advisor_id)
            ->where('topic', $request->old_topic)
            ->where('note', $request->old_note)
            ->update([
                'topic' => $request->topic,
                'note' => $request->note
            ]);
        }
        $student = User::find($request->student_id);
        return redirect()->route('student.notes', $student);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function remove_note(Request $request) {
        //add policy check for restriction
        DB::table('student_advisor_notes')
            ->where('student_id', $request->student_id)
            ->where('advisor_id', $request->advisor_id)
            ->where('topic', $request->topic)
            ->where('note', $request->note)
            ->delete();

        return back();
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function student_circumstances(User $student) {
        $circumstances = DB::table('circumstances')
        ->join('student_circumstance', 'circumstances.id', 'student_circumstance.circumstance_id')
        ->join('users', 'users.id', 'student_circumstance.student_id')
        ->where('users.id', $student->id)
        ->paginate(8);
    
        return view('students.student_circumstances', [
            'student' => $student,
            'circumstances' => $circumstances
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function student_notes(User $student) {
        $notes = DB::table('student_advisor_notes')
        ->where('student_advisor_notes.student_id', $student->id)
        ->where('student_advisor_notes.advisor_id', auth()->user()->id)
        ->paginate(8);
    
        return view('students.student_advisor_notes', [
            'student' => $student,
            'notes' => $notes,
            'advisor' => auth()->user()
        ]);
    }
}
