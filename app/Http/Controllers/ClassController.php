<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Classe;
use App\Models\User;

class ClassController extends Controller
{
    public function index()
    {
        $classes1 = Classe::with(['students'])
        ->where('year', '=', '1')
        ->paginate(8);

        foreach($classes1 as $class) {
            $average_grade = DB::table('user_class')
            ->select(\DB::raw('round(AVG(CAST(user_class.grade as numeric)), 1) as average_grade'))
            ->from('user_class')
            ->where('user_class.class_id', '=', $class->id)
            ->groupBy('user_class.class_id')
            ->get();

            if($average_grade->count() == 0)
                $class->average_grade = 'No Grades Yet';
            else
                $class->average_grade = $average_grade[0]->average_grade;
        }

        //dd($classes1);

        $classes2 = Classe::with(['students'])
        ->where('year', '=', '2')
        ->get();

        $classes3 = Classe::with(['students'])
        ->where('year', '=', '3')
        ->get();

        $classes4 = Classe::with(['students'])
        ->where('year', '=', '4')
        ->get();

        return view('classes.index', [
            'classes1' => $classes1,
            'classes2' => $classes2,
            'classes3' => $classes3,
            'classes4' => $classes4
        ]);
    }

    public function student_records(User $student)
    {
        $lists = DB::table('users')
            ->join('user_class', 'users.id', '=', 'user_class.user_id')
            ->join('classes', 'classes.id', '=', 'user_class.class_id')
            ->from('classes', 'users', 'user_class')
            ->where('users.id', $student->id)
            ->paginate(8);

        foreach($lists as $list) {
            $list->fullname = $student->fullname;
        }

        return view('classes.student_records', [
            'lists' => $lists
        ]);
    }

    public function class_records(Classe $class)
    {
        $lists = DB::table('classes')
            ->select('users.fullname', 'user_class.grade', 'user_class.attendance')
            ->from('classes')
            ->join('user_class', 'user_class.class_id', '=', 'classes.id')
            ->join('users', 'users.id', '=', 'user_class.user_id')
            ->join('user_role', 'user_role.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('classes.id', $class->id)
            ->where('roles.name', '=', 'Student')
            ->groupBy('users.fullname', 'user_class.grade', 'user_class.attendance')
            ->paginate(8);

        return view('classes.class_records', [
            'lists' => $lists,
            'class' => $class
        ]);
    }
}