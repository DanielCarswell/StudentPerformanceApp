<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Classe;

class ChartController extends Controller
{
    public function class_grades(Classe $class)
    {
        $grades_model = DB::table('classes')
            ->select('users.fullname', 'user_class.class_id', 'user_class.grade', 'user_class.attendance')
            ->from('classes')
            ->join('user_class', 'classes.id', '=', 'user_class.class_id')
            ->join('users', 'users.id', '=', 'user_class.user_id')
            ->join('user_role', 'user_role.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('classes.id', $class->id)
            ->get();

        $class = DB::table('classes')
        ->where('id', $class->id)
        ->first();
        
    	return view('/graph/class_grades', ['grades_model' => $grades_model, 'class' => $class]);
    }

    public function class_grades_example()
    {
        $grades_model = DB::table('classes')
            ->select('users.fullname', 'user_class.class_id', 'user_class.grade', 'user_class.attendance')
            ->from('classes')
            ->join('user_class', 'classes.id', '=', 'user_class.class_id')
            ->join('users', 'users.id', '=', 'user_class.user_id')
            ->join('user_role', 'user_role.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('classes.id', '=', '12')
            ->get();

            $class = DB::table('classes')
            ->where('id', '12')
            ->first();
        
    	return view('/graph/class_grades', ['grades_model' => $grades_model, 'class' => $class]);
    }
}
