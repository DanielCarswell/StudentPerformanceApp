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
    * Generates PDF for a students class records.
    *
    * @param int student_id
    * @return pdf     
    */
    public function student_records(int $student_id) {
        //Gets all Student classes.
        $lists = DB::table('classes')
            ->select('users.fullname', 'classes.name', 'student_class.grade', 'student_class.attendance')
            ->from('classes')
            ->join('student_class', 'student_class.class_id', '=', 'classes.id')
            ->join('users', 'users.id', '=', 'student_class.student_id')
            ->join('user_role', 'user_role.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->where('users.id', '=', $student_id)
            ->groupBy('users.fullname', 'classes.name', 'student_class.grade', 'student_class.attendance')
            ->get();

        //Gets student from database.
        $student = User::find($student_id);

        //PDF view initialization.
        $pdf = PDF::loadView('classes.student_records_pdf', [
            'student' => $student,
            'lists' => $lists
        ]);
    
        //Downloads PDF.
        return $pdf->download($student->fullname . '_student_records.pdf');
    }

    /**
    * Generates PDF of records for a Class and each students average grade.
    *
    * @param 
    * @return pdf     
    */
    public function class_records(int $class_id) {
        //Gets all students for class.
        $lists = DB::table('classes')
            ->select('users.fullname', 'student_class.grade', 'student_class.attendance')
            ->from('classes')
            ->join('student_class', 'student_class.class_id', '=', 'classes.id')
            ->join('users', 'users.id', '=', 'student_class.student_id')
            ->join('user_role', 'user_role.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'user_role.role_id')
            ->join('lecturer_class', 'lecturer_class.class_id', '=', 'classes.id')
            ->where('classes.id', '=', $class_id)
            ->groupBy('users.fullname', 'student_class.grade', 'student_class.attendance')
            ->get();

        //Gets class from database.
        $class = Classe::find($class_id);
        
        //PDF view initialization.
        $pdf = PDF::loadView('classes.class_records_pdf', [
            'class' => $class,
            'lists' => $lists
        ]);
    
        //Downloads PDF.
        return $pdf->download($class->name . '_class_records.pdf');
    }
}
