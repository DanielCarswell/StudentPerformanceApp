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
        $classes = Classe::with(['students'])
        ->where('year', '=', '1')
        ->paginate(8);

        foreach($classes as $class) {
            $average_grade = DB::table('student_class')
            ->select(\DB::raw('round(AVG(CAST(student_class.grade as numeric)), 1) as average_grade'))
            ->from('student_class')
            ->where('student_class.class_id', '=', $class->id)
            ->groupBy('student_class.class_id')
            ->get();

            if($average_grade->count() == 0)
                $class->average_grade = 'No Grades Yet';
            else
                $class->average_grade = $average_grade[0]->average_grade;
        }

        return view('classes.index', [
            'classes' => $classes
        ]);
    }

    public function admin_index()
    {
        $classes = Classe::with(['students'])
        ->paginate(8);

        return view('admin.classes.index', [
            'classes' => $classes
        ]);
    }

    public function create(Request $request) {
        return view('admin.classes.create_class');
    }

    public function delete(Classe $class) {
        return view('admin.classes.delete', [
            'class' => $class
        ]);
    }

    public function destroy(int $class_id)
    {
        $class = Classe::find($class_id);   
        $class->delete();
        return $this->index();
    }

    public function search_classes(Request $request) {
        $q = $request->q;
        $classes = Classe::where ( 'name', 'LIKE', '%' . $q . '%' )->orWhere ( 'class_code', 'LIKE', '%' . $q . '%' )->paginate(8);
        
        return view('admin.classes.index', [
            'classes' => $classes
        ]);
    }

    public function student_records(User $student)
    {
        $lists = DB::table('users')
            ->join('student_class', 'users.id', '=', 'student_class.student_id')
            ->join('classes', 'classes.id', '=', 'student_class.class_id')
            ->from('classes', 'users', 'student_class')
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
            ->select('users.fullname', 'student_class.grade', 'student_class.attendance')
            ->from('classes')
            ->join('student_class', 'student_class.class_id', '=', 'classes.id')
            ->join('users', 'users.id', '=', 'student_class.student_id')
            ->join('user_role', 'user_role.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('classes.id', $class->id)
            ->where('roles.name', '=', 'Student')
            ->groupBy('users.fullname', 'student_class.grade', 'student_class.attendance')
            ->paginate(8);

        return view('classes.class_records', [
            'lists' => $lists,
            'class' => $class
        ]);
    }
}