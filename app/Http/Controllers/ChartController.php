<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\ClassModel;

class ChartController extends Controller
{
    public function class_grades(ClassModel $class)
    {
        $grades_model = DB::table('class_models')
            ->select('users.fullname', 'user_class_models.class_models_id', 'user_class_models.grade', 'user_class_models.attendance')
            ->from('class_models')
            ->join('user_class_models', 'class_models.id', '=', 'user_class_models.class_models_id')
            ->join('users', 'users.id', '=', 'user_class_models.user_id')
            ->join('user_role', 'user_role.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('class_models.id', $class->id)
            ->get();

        $class = DB::table('class_models')
        ->where('id', $class->id)
        ->first();
        
    	return view('/graph/class_grades', ['grades_model' => $grades_model, 'class' => $class]);
    }

    public function class_grades_example()
    {
        $grades_model = DB::table('class_models')
            ->select('users.fullname', 'user_class_models.class_models_id', 'user_class_models.grade', 'user_class_models.attendance')
            ->from('class_models')
            ->join('user_class_models', 'class_models.id', '=', 'user_class_models.class_models_id')
            ->join('users', 'users.id', '=', 'user_class_models.user_id')
            ->join('user_role', 'user_role.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('class_models.id', '=', '12')
            ->get();

            $class = DB::table('class_models')
            ->where('id', '12')
            ->first();
        
    	return view('/graph/class_grades', ['grades_model' => $grades_model, 'class' => $class]);
    }
}
