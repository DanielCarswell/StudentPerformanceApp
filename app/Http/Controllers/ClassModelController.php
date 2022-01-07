<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\ClassModel;
use App\Models\User;

class ClassModelController extends Controller
{
    public function index()
    {
        $classes1 = ClassModel::with(['students'])
        ->where('year', '=', '1')
        ->paginate(8);

        foreach($classes1 as $class) {
            $average_grade = DB::table('user_class_models')
            ->select(\DB::raw('round(AVG(CAST(user_class_models.grade as numeric)), 1) as average_grade'))
            ->from('user_class_models')
            ->where('user_class_models.class_models_id', '=', $class->id)
            ->groupBy('user_class_models.class_models_id')
            ->get();

            if($average_grade->count() == 0)
                $class->average_grade = 'No Grades Yet';
            else
                $class->average_grade = $average_grade[0]->average_grade;
        }

        //dd($classes1);

        $classes2 = ClassModel::with(['students'])
        ->where('year', '=', '2')
        ->get();

        $classes3 = ClassModel::with(['students'])
        ->where('year', '=', '3')
        ->get();

        $classes4 = ClassModel::with(['students'])
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
            ->join('user_class_models', 'users.id', '=', 'user_class_models.user_id')
            ->join('class_models', 'class_models.id', '=', 'user_class_models.class_models_id')
            ->from('class_models', 'users', 'user_class_models')
            ->where('users.id', $student->id)
            ->paginate(8);

        foreach($lists as $list) {
            $list->fullname = $student->fullname;
        }

        return view('classes.student_records', [
            'lists' => $lists
        ]);
    }

    public function class_records(ClassModel $class)
    {
        $lists = DB::table('class_models')
            ->select('users.fullname', 'user_class_models.grade', 'user_class_models.attendance')
            ->from('class_models')
            ->join('user_class_models', 'user_class_models.class_models_id', '=', 'class_models.id')
            ->join('users', 'users.id', '=', 'user_class_models.user_id')
            ->join('user_role', 'user_role.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('class_models.id', $class->id)
            ->where('roles.name', '=', 'Student')
            ->groupBy('users.fullname', 'user_class_models.grade', 'user_class_models.attendance')
            ->paginate(8);

        return view('classes.class_records', [
            'lists' => $lists,
            'class' => $class
        ]);
    }
}