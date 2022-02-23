<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class StudentController extends Controller
{
    public function index()
    {
        $students1 = User::with(['classes'])
        ->where('id', '!=', 1)
        ->whereIn('id', range(3,12))
        ->paginate(8);

        foreach($students1 as $student) {
            $student->average_grade = (\DB::table('student_class')
            ->select(\DB::raw('round(AVG(CAST(student_class.grade as numeric)), 1) as average_grade'))
            ->where('student_class.student_id', '=', $student->id)
            ->groupBy('student_class.student_id')
            ->get()[0]->average_grade);
        }

        $students2 = User::with(['classes'])
        ->where('id', '!=', 1)
        ->whereIn('id', range(12,21))
        ->get();

        $students3 = User::with(['classes'])
        ->where('id', '!=', 1)
        ->whereIn('id', range(22,31))
        ->get();

        $students4 = User::with(['classes'])
        ->where('id', '!=', 1)
        ->whereIn('id', range(32,41))
        ->get();

        return view('students.index', [
            'students1' => $students1,
            'students2' => $students2,
            'students3' => $students3,
            'students4' => $students4
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
