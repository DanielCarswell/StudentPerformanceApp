<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Classe;

class ChartController extends Controller
{
    public function select_graph(Request $request) {
        if($request->graphtype == 'Student Ratings') {
            $class = Classe::find($request->class_id);
            return $this->class_ratings($class);
        }
        else if($request->graphtype == 'Student Grades') {
            $class = Classe::find($request->class_id);
            return $this->class_grades($class);
        }
        else if($request->graphtype == 'Student Attendance') {
            $class = Classe::find($request->class_id);
            return $this->class_attendance($class);
        }
        else if($request->graphtype == 'Student') {
            $student = User::find($request->student_id);
            return $this->student_ratings($student);
        }
        else if($request->graphtype == 'Combo') {
            $student = User::find($request->student_id);
            return $this->student_details($student);
        }
        
        return back();
    }

    public function student_details(User $student) {
        $classes = DB::table('classes')
        ->select('classes.name', 'student_class.grade', 'student_class.attendance')
        ->from('classes')
        ->join('student_class', 'student_class.class_id', '=', 'classes.id')
        ->where('student_class.student_id', '=', $student->id)
        ->get();

        return view('graphs.combochart', [
            'classes' => $classes,
            'student' => $student
        ]);
    }

    public function student_ratings(User $student) {
        //Local variables.
        $ratingCount1 = 0;
        $ratingCount2 = 0;
        $ratingCount3 = 0;

        $details = DB::table('users')
        ->select('student_class.grade', 'student_class.attendance')
        ->from('classes', 'users')
        ->join('student_class', 'student_class.student_id', '=', 'users.id')
        ->join('classes', 'classes.id', '=', 'student_class.class_id')
        ->where('users.id', '=', $student->id)
        ->get();

        foreach($details as $data) {
            if($data->attendance < 30 && $data->grade < 30)
                $ratingCount3 += 1;
            else if($data->attendance >= 60 && $data->grade >= 70)
                $ratingCount1 += 1;
            else
                $ratingCount2 += 1;
        }

        return view('graphs.pichart_student', [
            'ratingCount1' => $ratingCount1,
            'ratingCount2' => $ratingCount2,
            'ratingCount3' => $ratingCount3,
            'student' => $student
        ]);
    }

    public function class_ratings(Classe $class) {
        //Local variables.
        $ratingCount1 = 0;
        $ratingCount2 = 0;
        $ratingCount3 = 0;

        $details = DB::table('users')
        ->select('student_class.grade', 'student_class.attendance')
        ->from('classes', 'users')
        ->join('student_class', 'student_class.student_id', '=', 'users.id')
        ->join('classes', 'classes.id', '=', 'student_class.class_id')
        ->where('classes.id', '=', $class->id)
        ->get();

        foreach($details as $data) {
            if($data->attendance < 30 && $data->grade < 30)
                $ratingCount3 += 1;
            else if($data->attendance >= 60 && $data->grade >= 70)
                $ratingCount1 += 1;
            else
                $ratingCount2 += 1;
        }

        return view('graphs.pichart_class', [
            'ratingCount1' => $ratingCount1,
            'ratingCount2' => $ratingCount2,
            'ratingCount3' => $ratingCount3,
            'class' => $class
        ]);
    }

    public function class_grades(Classe $class)
    {
        $grades_model = DB::table('classes')
            ->select('users.fullname', 'student_class.class_id', 'student_class.grade')
            ->from('classes')
            ->join('student_class', 'classes.id', '=', 'student_class.class_id')
            ->join('users', 'users.id', '=', 'student_class.student_id')
            ->where('classes.id', $class->id)
            ->get();

        $class = DB::table('classes')
        ->where('id', $class->id)
        ->first();
        
    	return view('graphs/barchart_grades', ['grades_model' => $grades_model, 'class' => $class]);
    }

    public function class_attendance(Classe $class)
    {
        $attendance_model = DB::table('classes')
            ->select('users.fullname', 'student_class.class_id', 'student_class.attendance')
            ->from('classes')
            ->join('student_class', 'classes.id', '=', 'student_class.class_id')
            ->join('users', 'users.id', '=', 'student_class.student_id')
            ->where('classes.id', $class->id)
            ->get();

        $class = DB::table('classes')
        ->where('id', $class->id)
        ->first();
        
    	return view('graphs/barchart_attendance', ['attendance_model' => $attendance_model, 'class' => $class]);
    }

}
