<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\User;

class StudentController extends Controller
{
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
        }

        return view('students.index', [
            'students' => $students
        ]);
    }

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

    public function add_to_class(User $student, int $class_id){
        $assignments = Assignment::where('class_id', '=', $class_id)->get();

        DB::table('student_class')->insert([
            'name' => $request->assignmentname,
            'class_worth' => $request->classworth,
            'is_exam' => $request->isexam,
            'class_id' => $request->class_id
        ]);

        if($assignments->count()) {

        }
    }
}
