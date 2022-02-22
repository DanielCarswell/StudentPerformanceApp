<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Classe;

class ChartController extends Controller
{
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

        return view('graphs.pichart', [
            'ratingCount1' => $ratingCount1,
            'ratingCount2' => $ratingCount2,
            'ratingCount3' => $ratingCount3,
            'class' => $class
        ]);
    }

    public function class_grades(Classe $class)
    {
        $grades_model = DB::table('classes')
            ->select('users.fullname', 'student_class.class_id', 'student_class.grade', 'student_class.attendance')
            ->from('classes')
            ->join('student_class', 'classes.id', '=', 'student_class.class_id')
            ->join('users', 'users.id', '=', 'student_class.student_id')
            ->join('user_role', 'user_role.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('classes.id', $class->id)
            ->get();

        $class = DB::table('classes')
        ->where('id', $class->id)
        ->first();
        
    	return view('/graphs/class_grades', ['grades_model' => $grades_model, 'class' => $class]);
    }

    public function class_grades_example()
    {
        $grades_model = DB::table('classes')
            ->select('users.fullname', 'student_class.class_id', 'student_class.grade', 'student_class.attendance')
            ->from('classes')
            ->join('student_class', 'classes.id', '=', 'student_class.class_id')
            ->join('users', 'users.id', '=', 'student_class.user_id')
            ->join('user_role', 'user_role.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('classes.id', '=', '12')
            ->get();

            $class = DB::table('classes')
            ->where('id', '12')
            ->first();
        
    	return view('/graphs/class_grades', ['grades_model' => $grades_model, 'class' => $class]);
    }
}
