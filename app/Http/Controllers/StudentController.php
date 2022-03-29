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
    * Returns Advising Students model with All students assigned to Advisor
    * and their average grade and attendance.
    *
    * @return view     
    */
    public function index()
    {
        //Gets all students for logged in Advisor.
        $students = User::with(['classes'])
        ->join('student_advisor', 'student_advisor.student_id', '=', 'users.id')
        ->where('student_advisor.advisor_id', '=', auth()->user()->id)
        ->paginate(8);

        //Gets average grade and attendance for each student.
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
    * Returns add student circumstance view passing all circumstances.
    *
    * @param \App\Models\User student
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
    * Adds circumstance to Student.
    *
    * @param  \Illuminate\Http\Request request
    * @return route.redirect     
    */
    public function update_circumstance(Request $request) {
        //Checking circumstance credentials are valid.
        $credentials = $request->validate([
            'circumstance' => ['required', 'max:255']
        ]); 

        //Check that circumstance has been selected and not default element.
        if($request->circumstance == 'Select Circumstance')
            return back()->withErrors([
                'circumstance' => 'Please select a circumstance from dropdown.'
            ]);

        //Gets circumstance from database.
        $circumstance = Circumstance::with(['circumstance_links'])->where('name', $request->circumstance)->first();

        //Adds circumstacne to student.
        $student_circumstances = DB::table('circumstances')
        ->select('circumstances.id', 'circumstances.name', 'circumstances.information')
        ->from('circumstances')
        ->join('student_circumstance', 'student_circumstance.circumstance_id', '=', 'circumstances.id')
        ->join('users', 'student_circumstance.student_id', '=', 'users.id')
        ->where('users.id', $request->student_id)
        ->get();

        //Checks circumstance is not already assigned to student.
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

            //Gets student model for view.
            $student = User::find($request->student_id);

            //Send email to student with details on dealing with the circumstance.
            Mail::to($student->email)->send(new Circumstances($student, $circumstance->name, $circumstance->information, $circumstance->circumstance_links));
        }
            
        //Gets student model for view.
        $student = User::find($request->student_id);
        return redirect()->route('student.circumstances', $student);
    }

    /**
    * Removes student circumstance association.
    *
    * @param \Illuminate\Http\Request request
    * @return back.to.previous.view     
    */
    public function remove_circumstance(Request $request) {
        //Removes circumstance from student.
        DB::table('student_circumstance')
        ->where('student_id', $request->student_id)
        ->where('circumstance_id', $request->circumstance_id)
        ->delete();

        return back();
    }

    /**
    * Returns view to add note to student.
    *
    * @param \App\Models\User user
    * @return view     
    */
    public function add_note(User $student) {
        return view('students.add_advisor_note', [
            'student' => $student,
            'advisor' => auth()->user()
        ]);
    }

    /**
    * Adds note to student if valid.
    * note can only be viewed by advisor
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
        }

        //Gets student model for view.
        $student = User::find($request->student_id);
        return redirect()->route('student.notes', $student);
    }

    /**
    * Returns view to edit advisors student note.
    *
    * @param int student_id
    * @param string topic
    * @param string note
    * @return view     
    */
    public function edit_note(int $student_id, string $topic, string $note) {
        
        //Gets student model for view.
        $student = User::find($student_id);

        return view('students.edit_advisor_note', [
            'note' => $note,
            'student' => $student,
            'topic' => $topic,
            'advisor' => auth()->user()
        ]);
    }

    /**
    * Modifies note for student if valid
    * note can only be viewed by advisor
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

        //Updates note if valid.
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

        //Gets student model for view.
        $student = User::find($request->student_id);
        return redirect()->route('student.notes', $student);
    }

    /**
    * Deletes note.
    *
    * @param \Illuminate\Http\Request request
    * @return back.to.previous.view
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
    * Returns view for student and their circumstances.
    *
    * @param \App\Model\User student
    * @return view     
    */
    public function student_circumstances(User $student) {
        //Get all circumstances for student.
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
    * Loads view with student and notes associated for current logged in advisor.
    *
    * @param \App\Models\User student
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
