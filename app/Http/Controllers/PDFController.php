<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Classe;
use App\Models\User;

use PDF;

class PDFController extends Controller
{
    /**
    * Ensures user authentication to access Controller.  
    */
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    /**
    *
    * @param 
    * @return view     
    */
    public function student_records(int $student_id) {
        $lists = DB::table('users')
            ->join('student_class', 'users.id', '=', 'student_class.student_id')
            ->join('classes', 'classes.id', '=', 'student_class.class_id')
            ->from('classes', 'users', 'student_class')
            ->where('users.id', $student_id)
            ->get();

        $student = User::find($student_id);

        foreach($lists as $list) {
            $list->fullname = $student->fullname;
        }

        $pdf = PDF::loadView('classes.student_records_pdf', [
            'student' => $student,
            'lists' => $lists
        ]);
    
        return $pdf->download($student->fullname . '_student_records.pdf');
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function class_records(int $class_id) {
        $lists = DB::table('classes')
            ->select('users.fullname', 'student_class.grade', 'student_class.attendance')
            ->from('classes')
            ->join('student_class', 'student_class.class_id', '=', 'classes.id')
            ->join('users', 'users.id', '=', 'student_class.student_id')
            ->join('user_role', 'user_role.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->join('lecturer_class', 'lecturer_class.class_id', '=', 'classes.id')
            ->where('classes.id', '=', $class_id)
            //->where('roles.name', '=', 'Student')
            ->where('lecturer_class.lecturer_id', '=', auth()->user()->id)
            ->groupBy('users.fullname', 'student_class.grade', 'student_class.attendance')
            ->get();

        $class = Classe::find($class_id);
        
        $pdf = PDF::loadView('classes.class_records_pdf', [
            'class' => $class,
            'lists' => $lists
        ]);
    
        return $pdf->download($class->name . '_class_records.pdf');
    }
}
