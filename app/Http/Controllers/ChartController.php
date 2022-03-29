<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Classe;

class ChartController extends Controller
{
    /**
    * Ensures user authentication to access Controller.  
    */
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    /**
    * Redirects to appropriate Graph view based on Dropdown element selected.
    *
    * @param \Illuminate\Http\Request request
    * @return back.to.previous.view     
    */
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

    /**
    * Passes student and classes to view for graph of Student Grades And Attendance for all classes.
    *
    * @param \App\Models\User user
    * @return view     
    */
    public function student_details(User $student) {
        //Gets all classes for the passed student.
        $classes = DB::table('classes')
        ->select('classes.name', 'student_class.grade', 'student_class.attendance')
        ->from('classes')
        ->join('student_class', 'student_class.class_id', '=', 'classes.id')
        ->where('student_class.student_id', '=', $student->id)
        ->get();

        //Set grade and attendance 0 if null as no grades or attendance yet.
        foreach($classes as $grade) {
            if($grade->grade == null)
                $grade->grade = 0;

                if($grade->attendance == null)
                $grade->attendance = 0;
        }

        return view('graphs.combochart', [
            'classes' => $classes,
            'student' => $student
        ]);
    }

    /**
    * Passes student and classes to view for graph of Student Rating pichart for all class ratings.
    *
    * @param 
    * @return view     
    */
    public function student_ratings(User $student) {
        //Initialize local variables.
        $ratingCount1 = 0;
        $ratingCount2 = 0;
        $ratingCount3 = 0;

        //Get all grades and attendance for passed student classes.
        $details = DB::table('users')
        ->select('student_class.grade', 'student_class.attendance')
        ->from('users')
        ->join('student_class', 'student_class.student_id', '=', 'users.id')
        ->join('classes', 'classes.id', '=', 'student_class.class_id')
        ->where('users.id', '=', $student->id)
        ->get();

        //Set grade and attendance 0 if null as no grades or attendance yet.
        foreach($details as $grade) {
            if($grade->grade == null)
                $grade->grade = 0;

                if($grade->attendance == null)
                $grade->attendance = 0;
        }

        //Increase rating count for rating 1, 2 or 3 appropriately.
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

    /**
    * Get ratings for view Graph for all Students in passed class.
    *
    * @param \App\Models\Classe class
    * @return view     
    */
    public function class_ratings(Classe $class) {
        //Local variables.
        $ratingCount1 = 0;
        $ratingCount2 = 0;
        $ratingCount3 = 0;

        //Get all grades and attendance for passed class students.
        $details = DB::table('users')
        ->select('student_class.grade', 'student_class.attendance')
        ->from('users')
        ->join('student_class', 'student_class.student_id', '=', 'users.id')
        ->join('classes', 'classes.id', '=', 'student_class.class_id')
        ->where('classes.id', '=', $class->id)
        ->get();

        //Set grade and attendance 0 if null as no grades or attendance yet.
        foreach($details as $grade) {
            if($grade->grade == null)
                $grade->grade = 0;

                if($grade->attendance == null)
                $grade->attendance = 0;
        }

        //Increase rating count for rating 1, 2 or 3 appropriately.
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

    /**
    * Gets all student grades in passed class for barchart of all student grades.
    *
    * @param \App\Models\Classe class
    * @return view     
    */
    public function class_grades(Classe $class)
    {
        //Get full name and grade for each student in class.
        $grades_model = DB::table('classes')
            ->select('users.fullname', 'student_class.class_id', 'student_class.grade')
            ->from('classes')
            ->join('student_class', 'classes.id', '=', 'student_class.class_id')
            ->join('users', 'users.id', '=', 'student_class.student_id')
            ->where('classes.id', $class->id)
            ->get();

        //Set grade 0 if null as no grades yet.
        foreach($grades_model as $grade) {
            if($grade->grade == null)
                $grade->grade = 0;
        }

        //get class model for view.
        $class = DB::table('classes')
        ->where('id', $class->id)
        ->first();

    	return view('graphs/barchart_grades', [
            'grades_model' => $grades_model, 
            'class' => $class
        ]);
    }


    /**
    * Gets all student attendance in passed class for graph view.
    *
    * @param \App\Models\Classe class
    * @return view     
    */
    public function class_attendance(Classe $class)
    {
        //Gets fullname, attendance for all students in class with class_id for display.
        $attendance_model = DB::table('classes')
            ->select('users.fullname', 'student_class.class_id', 'student_class.attendance')
            ->from('classes')
            ->join('student_class', 'classes.id', '=', 'student_class.class_id')
            ->join('users', 'users.id', '=', 'student_class.student_id')
            ->where('classes.id', $class->id)
            ->get();

        //Set attendance 0 if null as no attendance yet.
        foreach($attendance_model as $attendance) {
            if($attendance->attendance == null)
                $attendance->attendance = 0;
        }

        //Gets class model for view.
        $class = DB::table('classes')
        ->where('id', $class->id)
        ->first();
        
    	return view('graphs/barchart_attendance', [
            'attendance_model' => $attendance_model,
            'class' => $class
        ]);
    }

}
