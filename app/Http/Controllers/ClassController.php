<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


use App\Mail\LowGradeNotification;
use App\Mail\GradeUpdateNotification;
use App\Mail\Circumstance;

use App\Models\Assignment;
use App\Models\Classe;
use App\Models\User;

class ClassController extends Controller
{
    /**
    * Ensures user authentication to access Controller.  
    */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
    * Get classes and average grades for the classes
    * associated with currently logged in Admin/Lecturer other roles blocked.
    *
    * @return view     
    */
    public function index()
    {
        /**Get all Classes with associated Students and Lecturers 
           where current user is a lecturer for the class.*/
        $classes = Classe::with(['students'])
        ->with(['lecturers'])
        ->join('lecturer_class', 'lecturer_class.class_id', '=', 'classes.id')
        ->where('lecturer_class.lecturer_id', '=', auth()->user()->id)
        ->paginate(8);

        //For all classes, get the average grade or 'No Grades Yet' Placeholder for display.
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

        //For all classes, get the average attendance or 'No Attendance Yet' Placeholder for display.
        foreach($classes as $class) {
            $average_attendance = DB::table('student_class')
            ->select(\DB::raw('round(AVG(CAST(student_class.attendance as numeric)), 1) as average_attendance'))
            ->from('student_class')
            ->where('student_class.class_id', '=', $class->id)
            ->groupBy('student_class.class_id')
            ->get();

            if($average_attendance->count() == 0)
                $class->average_attendance = 'No Attendance Yet';
            else
                $class->average_attendance = $average_attendance[0]->average_attendance;
        }

        return view('classes.index', [
            'classes' => $classes
        ]);
    }

    /**
    * Get all Classes for Admin/Moderator or all Classes Lecturer is associated to
    * and pass to view.
    *
    * @return view     
    */
    public function admin_index()
    {
        //Get classes from Database, all if Admin/Moderator or Lecturer specific.
        if(!auth()->user()->hasRole(['Admin', 'Moderator']))
            $classes = Classe::with(['students'])->whereRelation('lecturers', 'id', '=', auth()->user()->id)->paginate(8);
        else
            $classes = Classe::with(['students'])->paginate(8);

        return view('admin.classes.index', [
            'classes' => $classes
        ]);
    }

    /**
    * Return view for Creating a class.
    *
    * @return view     
    */
    public function create() {
        return view('admin.classes.create_class');
    }

    /**
    * Add new Class to Database or return error.
    *
    * @param Illuminate\Http\Request request
    * @return route.redirect     
    */
    public function create_class(Request $request) {
        //Check class credentials are appropriate.
        $credentials = $request->validate([
            'classname' => ['required', 'max:255']
        ]);

        //Add class to Database.
        DB::table('classes')->insert([
            'name' => $request->classname
        ]);

        //Initializes class_id variable and gets all classes.
        $class_id = 0;
        $classes = DB::table('classes')->get();

        //Runs through all classes to get Id of last class in database.
        foreach($classes as $class) {
            $class_id = $class->id;
        }

        //Add logged in user as a Lecturer for the newly created Class.
        DB::table('lecturer_class')->insert([
            'lecturer_id' => auth()->user()->id,
            'class_id' => $class_id
        ]);

        return redirect()->route('admin_classes');
    }

    /**
    * Passes class model to Class Edit Page.
    *
    * @param \App\Models\Classe class
    * @return view     
    */
    public function edit(Classe $class) {
        return view('admin.classes.edit', [
            'class' => $class
        ]);
    }

    /**
    * Edits Class details in Database.
    *
    * @param \Illuminate\Http\Request request
    * @return view     
    */
    public function modify(Request $request) {

        //Checking class credentials are valid.
        $credentials = $request->validate([
            'classname' => ['required', 'max:255']
        ]);

        //Updating class in database if valid credentials.
        if ($credentials) {
            DB::table('classes')
            ->where('classes.id', '=', $request->class_id)
            ->update([
                'name' => $request->classname
            ]);
        }

        return redirect()->route('admin_classes');
    }

    /**
    * Passes class model to Delete Class Page.
    *
    * @param \App\Models\Classe class
    * @return view     
    */
    public function delete(Classe $class) {
        return view('admin.classes.delete', [
            'class' => $class
        ]);
    }

    /**
    * Deletes Class from Database.
    *
    * @param int class_id
    * @return view     
    */
    public function destroy(int $class_id)
    {
        //Get class by Id.
        $class = Classe::find($class_id);   

        //Delete class.
        $class->delete();

        return redirect()->route('admin_classes');
    }

    /**
    * Searches classes by name for view.
    *
    * @param \Illuminate\Http\Request request
    * @return view     
    */
    public function search_classes(Request $request) {
        //Search for class names containing query string q.
        $q = $request->q;
        $classes = Classe::where ( 'name', 'LIKE', '%' . $q . '%' )->paginate(8);
        
        return view('admin.classes.index', [
            'classes' => $classes
        ]);
    }

    /**
    * Gets Assignments and average mark and passes to view.
    *
    * @param \App\Models\Classe class
    * @return view     
    */
    public function assignments(Classe $class) {
        //Get all assignments related to passed class.
        $assignments = Assignment::where('class_id', $class->id)->paginate(10);

        //Get Average grade for all Assignments or 'No Grades Yet' Placeholder.
        foreach($assignments as $assignment) {
            $average = DB::table('assignments')
            ->select(\DB::raw('round(AVG(CAST(student_assignment.percent as numeric)), 1) as average'))
            ->from('assignments')
            ->join('student_assignment', 'student_assignment.assignment_id', '=', 'assignments.id')
            ->where('assignments.id', '=', $assignment->id)
            ->get();

            if ($average[0]->average != null)
                $assignment->average = $average[0]->average;
            else
                $assignment->average = 'No Grades Yet';
        }

        return view('classes.assignments', [
            'class' => $class,
            'assignments' => $assignments
        ]);
    }

    /**
    * Get all students and their grades for passed Assignment for 
    * passed class and pass details to view.
    *
    * @param \App\Models\Assignment assignment
    * @param \App\Models\Classe class
    * @return view     
    */
    public function assignment_grades(Assignment $assignment, Classe $class) {
        //Get users id, fullname, assignment name and assignment mark/percent for all Students in class.
        $students = DB::table('users')
        ->select('users.id', 'users.fullname', 'assignments.name', 'student_assignment.percent')
        ->join('student_assignment', 'student_assignment.user_id', 'users.id')
        ->join('assignments', 'assignments.id', 'student_assignment.assignment_id')
        ->where('student_assignment.class_id', $class->id)
        ->where('student_assignment.assignment_id', $assignment->id)
        ->paginate(10);

        //If student does not have an assignment grade yet, set percent 0.
        foreach($students as $student)
            if($student->percent == null)
                $student->percent = 0;

        return view('classes.assignment_grades', [
            'assignment' => $assignment,
            'class' => $class,
            'students' => $students
        ]);
    }

    /**
    * Shows all records for a chosen Student.
    *
    * @param \App\Models\User student
    * @return view     
    */
    public function student_records(User $student)
    {
        //Get all student and associated classes details.
        $lists = DB::table('users')
            ->join('student_class', 'users.id', '=', 'student_class.student_id')
            ->join('classes', 'classes.id', '=', 'student_class.class_id')
            ->from('users')
            ->where('users.id', $student->id)
            ->paginate(8);

        return view('classes.student_records', [
            'lists' => $lists,
            'student' => $student
        ]);
    }

    /**
    * Shows all records for a chosen Class.
    *
    * @param \App\Models\Classe class
    * @return view     
    */
    public function class_records(Classe $class)
    {
        //Get all student names, grades and attendance for passed class.
        $lists = DB::table('student_class')
            ->select('users.fullname', 'student_class.grade', 'student_class.attendance')
            ->from('student_class')
            ->join('classes', 'student_class.class_id', '=', 'classes.id')
            ->join('users', 'users.id', '=', 'student_class.student_id')
            ->where('classes.id', '=', $class->id)
            ->groupBy('users.fullname', 'student_class.grade', 'student_class.attendance')
            ->paginate(8);

        return view('classes.class_records', [
            'lists' => $lists,
            'class' => $class
        ]);
    }

    /**
    * Gets all classes Students for class students page.
    *
    * @param \App\Models\Classe class
    * @return view     
    */
    public function students(Classe $class) {
        //Get all students in passed class.
        $students = DB::table('users')
        ->join('student_class', 'student_class.student_id', 'users.id')
        ->where('student_class.class_id', $class->id)
        ->paginate(10);

        //Get class mark for all students.
        foreach($students as $student)
            $student->class_mark = DB::table('student_class')->where('student_id', $student->id)->where('class_id', $class->id)->first()->grade;

        return view('admin.classes.students', [
            'class' => $class,
            'students' => $students
        ]);
    }

    /**
    * Gets all Students not yet associated to class for Add Student display.
    *
    * @param \App\Models\Classe class
    * @return view     
    */
    public function add(Classe $class) {
        //Initialize local variable.
        $ids = [];

        //Find all students in passed class.
        $students = DB::table('users')
        ->select('users.id')
        ->from('users')
        ->join('student_class', 'student_class.student_id', '=', 'users.id')
        ->where('student_class.class_id', $class->id)
        ->get();

        //Adds student ids to ids array for whereNotIn.
        foreach($students as $student)
            array_push($ids, $student->id);

        //Get all students from databases id and fullname that are not in the class currently.
        $students = DB::table('users')
        ->select('users.id', 'users.fullname')
        ->from('users')
        ->join('user_role', 'user_role.user_id', '=', 'users.id')
        ->join('roles', 'user_role.role_id', '=', 'roles.id')
        ->where('roles.name', 'Student')
        ->whereNotIn('users.id', $ids)
        ->paginate(10);

        return view('admin.classes.add_student', [
            'class' => $class,
            'students' => $students
        ]);
    }

    /**
    * Adds Student to the Class in Database.
    *
    * @param int class_id
    * @param int student_id
    * @return route.redirect     
    */
    public function add_student(int $class_id, int $student_id) {
        //Add student to class with 100% grade and attendance to start.
        DB::table('student_class')
        ->insert(['class_id' => $class_id, 'student_id' => $student_id]);

        //Get all assignments for class.
        $assignments = Assignment::where('class_id', $class_id)->get();

        //Add student association to all assignments for class.
        foreach($assignments as $assignment)
        {
            DB::table('student_assignment')
            ->insert(['class_id' => $class_id, 'user_id' => $student_id, 'assignment_id' => $assignment->id, 'percent' => 0]);
        }

        //get class model for view.
        $class = Classe::find($class_id);

        return redirect()->route('class.students', $class);
    }

    /**
    * Deletes student from class and associated assignments.
    *
    * @param int class_id
    * @param int student_id
    * @return back.to.previous.view     
    */
    public function delete_student(int $class_id, int $student_id) {
        //Delete student from class.
        DB::table('student_class')
        ->where('student_id', $student_id)
        ->where('class_id', $class_id)
        ->delete();

        //Delete student from assignments for class.
        DB::table('student_assignment')
        ->where('user_id', $student_id)
        ->where('class_id', $class_id)
        ->delete();

        return back();
    }

    /**
    * Return view for uploading students to a class.
    *
    * @param \Illuminate\Http\Request request
    * @return view     
    */
    public function upload_students(Request $request) {
        return view('admin.classes.upload_class_students', [
            'class_id' => $request->class_id
        ]);
    }

    /**
    * Return view for uploading attendance.
    *
    * @param \Illuminate\Http\Request request
    * @return view     
    */
    public function upload_attendance(Request $request) {
        return view('classes.upload_attendance', [
            'class_id' => $request->class_id
        ]);
    }

    /**
    * Updates a students class attendance in Database.
    *
    * @param \Illuminate\Http\Request request
    * @return route.redirect     
    */
    public function update_attendance(Request $request) {
        //Verifies attendance is a numeric value.
        $credentials = $request->validate([
            'attendance' => ['numeric']
        ]);

        //If credentials are valid and attendance is an appropriate value then updates attendance.
        if($credentials && $request->attendance >= 0 && $request->attendance <= 100)
            DB::table('student_class')
            ->where('class_id', '=', $request->class_id)
            ->where('student_id', '=', $request->student_id)
            ->update([
                'attendance' => $request->attendance
            ]);
        //Otherwise returns error that attendance must be between 0 and 100.
        else
            return back()->withErrors([
                'attendance' => 'Attendance must be between 0 and 100.'
            ]);

        //Get class model for view.
        $class = Classe::find($request->class_id);

        return redirect()->route('class_attendance', $class);
    }

    /**
    * Get students and attendance for a class and passes to view.
    *
    * @param \App\Models\Classe class
    * @return view     
    */
    public function class_attendance(Classe $class) {
        //Gets all students and their attendance for passed class.
        $students = DB::table('users')
        ->select('student_class.attendance', 'users.fullname', 'users.id')
        ->from('users')
        ->join('student_class', 'users.id', '=', 'student_class.student_id')
        ->where('student_class.class_id', $class->id)
        ->paginate(8);

        return view('classes.attendance', [
            'class' => $class,
            'students' => $students
        ]);
    }

    /**
    * Gets all lecturers for a given class for view.
    *
    * @param \App\Models\Classe class
    * @return view     
    */
    public function lecturers(Classe $class) {
        //Gets all lecturers in passed class.
        $lecturers = DB::table('users')
        ->join('lecturer_class', 'lecturer_class.lecturer_id', 'users.id')
        ->where('lecturer_class.class_id', $class->id)
        ->paginate(10);

        return view('admin.classes.lecturers', [
            'class' => $class,
            'lecturers' => $lecturers
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function add_lecturer(Classe $class) {
        //Initialize local variable.
        $ids = [];

        //Gets all lecturers in given class.
        $lecturers = DB::table('users')
        ->select('users.id')
        ->from('users')
        ->join('lecturer_class', 'lecturer_class.lecturer_id', '=', 'users.id')
        ->where('lecturer_class.class_id', $class->id)
        ->get();

        //Puts all lecturers in class ids in variable for whereNotIn.
        foreach($lecturers as $lecturer)
            array_push($ids, $lecturer->id);

        //Gets all lecturers not assigned to class.
        $lecturers = DB::table('users')
        ->select('users.id', 'users.fullname')
        ->from('users')
        ->join('user_role', 'user_role.user_id', '=', 'users.id')
        ->join('roles', 'user_role.role_id', '=', 'roles.id')
        ->where('roles.name', 'Lecturer')
        ->whereNotIn('users.id', $ids)
        ->paginate(10);

        return view('admin.classes.add_lecturer', [
            'class' => $class,
            'lecturers' => $lecturers
        ]);
    }

    /**
    * Adds Lecturer to Class in Database.
    *
    * @param int class_id
    * @param int lecturer_id
    * @return route.redirect     
    */
    public function lecturer_add(int $class_id, int $lecturer_id) {
        //Adds lecturer to class.
        DB::table('lecturer_class')
        ->insert(['class_id' => $class_id, 'lecturer_id' => $lecturer_id]);

        //Gets class model for view.
        $class = Classe::find($class_id);

        return redirect()->route('class.lecturers', $class);
    }

    /**
    * Deletes lecturer from class in database.
    *
    * @param int class_id
    * @param int lecturer_id
    * @return route.redirect     
    */
    public function delete_lecturer(int $class_id, int $lecturer_id) {
        //Delete lecturer from class.
        DB::table('lecturer_class')
        ->where('lecturer_id', $lecturer_id)
        ->where('class_id', $class_id)
        ->delete();

        //Gets class model for view.
        $class = Classe::find($class_id);

        return redirect()->route('class.lecturers', $class);
    }

    /**
    * Search students that can be added to class for view.
    *
    * @param \Illuminate\Http\Request request
    * @return view     
    */
    public function search_class_students(Request $request) {
        //Initialize local variables.
        $q = $request->q;
        $ids = [];

        //Get ids of Students in class.
        $student_ids = DB::table('users')
        ->select('users.id')
        ->from('users')
        ->join('student_class', 'student_class.student_id', '=', 'users.id')
        ->where('student_class.class_id', $request->class_id)
        ->get();

        //Adds ids to array for whereNotIn query.
        foreach($student_ids as $id)
            array_push($ids, $id->id);

        //Gets all students with name containing query input q and not already in class.
        $students = DB::table('users')
        ->select('users.id', 'users.fullname')
        ->from('users')
        ->join('student_class', 'student_class.student_id', '=', 'users.id')
        ->where( 'users.fullname', 'LIKE', '%' . $q . '%' )
        ->whereNotIn('users.id', $ids)
        ->distinct()
        ->paginate(8);

        //Get class model for view.
        $class = Classe::find($request->class_id);

        return view('admin.classes.add_student', [
            'class' => $class,
            'students' => $students
        ]);
    }

    /**
    * Search lecturers that can be added to class for view.
    *
    * @param \Illuminate\Http\Request request
    * @return view     
    */
    public function search_class_lecturers(Request $request) {
        //Initialize local variables.
        $q = $request->q;
        $ids = [];

        //Get ids of Lecturers in class.
        $lecturer_ids = DB::table('users')
        ->select('users.id')
        ->from('users')
        ->join('lecturer_class', 'lecturer_class.lecturer_id', '=', 'users.id')
        ->where('lecturer_class.class_id', $request->class_id)
        ->where( 'users.fullname', 'LIKE', '%' . $q . '%' )
        ->get();

        //Adds ids to array for whereNotIn query.
        foreach($lecturer_ids as $id)
            array_push($ids, $id->id);

        //Gets all lecturers with name containing query input q and not already in class.
        $lecturers = DB::table('users')
        ->select('users.id', 'users.fullname')
        ->from('users')
        ->join('student_class', 'student_class.student_id', '=', 'users.id')
        ->where( 'users.fullname', 'LIKE', '%' . $q . '%' )
        ->whereNotIn('users.id', $ids)
        ->distinct()
        ->paginate(8);

        //get class model for view
        $class = Classe::find($request->class_id);

        return view('admin.classes.add_lecturer', [
            'class' => $class,
            'lecturers' => $lecturers
        ]);
    }
}