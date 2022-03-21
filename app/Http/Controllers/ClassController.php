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
    public function index()
    {
        $classes = Classe::with(['students'])
        ->with(['lecturers'])
        ->join('lecturer_class', 'lecturer_class.class_id', '=', 'classes.id')
        ->where('lecturer_class.lecturer_id', '=', auth()->user()->id)
        ->paginate(8);

        //dd('hi');
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

    public function create() {
        return view('admin.classes.create_class');
    }

    public function create_class(Request $request) {
        $credentials = $request->validate([
            'classname' => ['required', 'max:255']
        ]);

        DB::table('classes')->insert([
            'name' => $request->classname
        ]);

        $class_id = 0;
        $classes = DB::table('classes')->get();

        foreach($classes as $class) {
            $class_id = $class->id;
        }

        DB::table('lecturer_class')->insert([
            'lecturer_id' => auth()->user()->id,
            'class_id' => $class_id
        ]);

        return redirect()->route('admin_classes');
    }

    public function create_lecturer() {
        return view('classes.create');
    }

    public function lecturer_create(Request $request) {
        $credentials = $request->validate([
            'classname' => ['required', 'max:255']
        ]);

        if ($credentials) {
            DB::table('classes')->insert([
                'name' => $request->classname
            ]);

            $class_id = 0;
            $classes = DB::table('classes')->get();

            foreach($classes as $class) {
                $class_id = $class->id;
            }

            DB::table('lecturer_class')->insert([
                'lecturer_id' => auth()->user()->id,
                'class_id' => $class_id
            ]);
        }

        return redirect()->route('classes');
    }

    public function edit(Classe $class) {
        return view('admin.classes.edit', [
            'class' => $class
        ]);
    }

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

    public function delete(Classe $class) {
        return view('admin.classes.delete', [
            'class' => $class
        ]);
    }

    public function destroy(int $class_id)
    {
        $class = Classe::find($class_id);   
        $class->delete();
        return redirect()->route('admin_classes');
    }

    public function search_classes(Request $request) {
        $q = $request->q;
        $classes = Classe::where ( 'name', 'LIKE', '%' . $q . '%' )->paginate(8);
        
        return view('admin.classes.index', [
            'classes' => $classes
        ]);
    }

    public function assignments(Classe $class) {
        $assignments = Assignment::where('class_id', $class->id)->paginate(10);


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

    public function assignment_grades(Assignment $assignment, Classe $class) {
        $students = DB::table('users')
        ->select('users.id', 'users.fullname', 'assignments.name', 'student_assignment.percent')
        ->join('student_assignment', 'student_assignment.user_id', 'users.id')
        ->join('assignments', 'assignments.id', 'student_assignment.assignment_id')
        ->where('student_assignment.class_id', $class->id)
        ->where('student_assignment.assignment_id', $assignment->id)
        ->paginate(10);

        foreach($students as $student)
            if($student->percent == null)
                $student->percent = 0;

        return view('classes.assignment_grades', [
            'assignment' => $assignment,
            'class' => $class,
            'students' => $students
        ]);
    }

    public function student_records(User $student)
    {
        $lists = DB::table('users')
            ->join('student_class', 'users.id', '=', 'student_class.student_id')
            ->join('classes', 'classes.id', '=', 'student_class.class_id')
            ->from('users')
            ->where('users.id', $student->id)
            ->paginate(8);

        foreach($lists as $list) {
            $list->fullname = $student->fullname;
        }

        return view('classes.student_records', [
            'lists' => $lists,
            'student' => $student
        ]);
    }

    public function class_records(Classe $class)
    {
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

    public function students(Classe $class) {
        $students = DB::table('users')
        ->join('student_class', 'student_class.student_id', 'users.id')
        ->where('student_class.class_id', $class->id)
        ->paginate(10);

        foreach($students as $student)
            $student->class_mark = DB::table('student_class')->where('student_id', $student->id)->where('class_id', $class->id)->first()->grade;

        return view('admin.classes.students', [
            'class' => $class,
            'students' => $students
        ]);
    }

    public function add(Classe $class) {
        $ids = [];

        $students = DB::table('users')
        ->select('users.id')
        ->from('users')
        ->join('student_class', 'student_class.student_id', '=', 'users.id')
        ->join('user_role', 'user_role.user_id', '=', 'users.id')
        ->join('roles', 'user_role.role_id', '=', 'roles.id')
        ->where('student_class.class_id', $class->id)
        ->where('roles.name', 'Student')
        ->get();

        foreach($students as $student)
            array_push($ids, $student->id);

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

    public function add_student(int $class_id, int $student_id) {
        DB::table('student_class')
        ->insert(['class_id' => $class_id, 'student_id' => $student_id, 'grade' => 100, 'attendance' => 100]);

        $assignments = Assignment::where('class_id', $class_id)->get();

        foreach($assignments as $assignment)
        {
            DB::table('student_assignment')
            ->insert(['class_id' => $class_id, 'user_id' => $student_id, 'assignment_id' => $assignment->id, 'percent' => 0]);
        }

        $class = Classe::find($class_id);

        return redirect()->route('class.students', $class);
    }

    public function delete_student(int $class_id, int $student_id) {
        DB::table('student_class')
        ->where('student_id', $student_id)
        ->where('class_id', $class_id)
        ->delete();

        DB::table('student_assignment')
        ->where('user_id', $student_id)
        ->where('class_id', $class_id)
        ->delete();

        return back();
    }

    public function upload_students(Request $request) {
        return view('admin.classes.upload_class_students', [
            'class_id' => $request->class_id
        ]);
    }

    public function upload_attendance(Request $request) {
        return view('classes.upload_attendance', [
            'class_id' => $request->class_id
        ]);
    }

    public function update_attendance(Request $request) {
        $credentials = $request->validate([
            'attendance' => ['numeric']
        ]);

        if($credentials && $request->attendance >= 0 && $request->attendance <= 100)
            DB::table('student_class')
            ->where('class_id', '=', $request->class_id)
            ->where('student_id', '=', $request->student_id)
            ->update([
                'attendance' => $request->attendance
            ]);
        else
            return back()->withErrors([
                'attendance' => 'Attendance must be between 0 and 100%.'
            ]);

        $class = Classe::find($request->class_id);

        return redirect()->route('class_attendance', $class);
    }

    public function class_attendance(Classe $class) {
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

    public function lecturers(Classe $class) {
        $lecturers = DB::table('users')
        ->join('lecturer_class', 'lecturer_class.lecturer_id', 'users.id')
        ->where('lecturer_class.class_id', $class->id)
        ->paginate(10);

        return view('admin.classes.lecturers', [
            'class' => $class,
            'lecturers' => $lecturers
        ]);
    }

    public function add_lecturer(Classe $class) {
        $ids = [];

        $lecturers = DB::table('users')
        ->select('users.id')
        ->from('users')
        ->join('lecturer_class', 'lecturer_class.lecturer_id', '=', 'users.id')
        ->join('user_role', 'user_role.user_id', '=', 'users.id')
        ->join('roles', 'user_role.role_id', '=', 'roles.id')
        ->where('lecturer_class.class_id', $class->id)
        ->where('roles.name', 'Lecturer')
        ->get();

        foreach($lecturers as $lecturer)
            array_push($ids, $lecturer->id);

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

    public function lecturer_add(int $class_id, int $lecturer_id) {
        DB::table('lecturer_class')
        ->insert(['class_id' => $class_id, 'lecturer_id' => $lecturer_id]);

        $class = Classe::find($class_id);

        return redirect()->route('class.lecturers', $class);
    }

    public function delete_lecturer(int $class_id, int $lecturer_id) {
        DB::table('lecturer_class')
        ->where('lecturer_id', $lecturer_id)
        ->where('class_id', $class_id)
        ->delete();

        $class = Classe::find($class_id);

        return redirect()->route('class.lecturers', $class);
    }

    public function search_class_students(Request $request) {
        $q = $request->q;
        $ids = [];

        $student_ids = DB::table('users')
        ->select('users.id')
        ->from('users')
        ->join('student_class', 'student_class.student_id', '=', 'users.id')
        ->where('student_class.class_id', $request->class_id)
        ->where( 'users.fullname', 'LIKE', '%' . $q . '%' )
        ->get();

        foreach($student_ids as $id)
            array_push($ids, $id->id);

        $students = DB::table('users')
        ->select('users.id', 'users.fullname')
        ->from('users')
        ->join('student_class', 'student_class.student_id', '=', 'users.id')
        ->where( 'users.fullname', 'LIKE', '%' . $q . '%' )
        ->whereNotIn('users.id', $ids)
        ->distinct()
        ->paginate(8);

        $class = Classe::find($request->class_id);

        return view('admin.classes.add_student', [
            'class' => $class,
            'students' => $students
        ]);
    }

    public function search_class_lecturers(Request $request) {
        $q = $request->q;
        $ids = [];

        $lecturer_ids = DB::table('users')
        ->select('users.id')
        ->from('users')
        ->join('lecturer_class', 'lecturer_class.lecturer_id', '=', 'users.id')
        ->where('lecturer_class.class_id', $request->class_id)
        ->where( 'users.fullname', 'LIKE', '%' . $q . '%' )
        ->get();

        foreach($lecturer_ids as $id)
            array_push($ids, $id->id);

        $lecturers = DB::table('users')
        ->select('users.id', 'users.fullname')
        ->from('users')
        ->join('student_class', 'student_class.student_id', '=', 'users.id')
        ->where( 'users.fullname', 'LIKE', '%' . $q . '%' )
        ->whereNotIn('users.id', $ids)
        ->distinct()
        ->paginate(8);

        $class = Classe::find($request->class_id);

        return view('admin.classes.add_lecturer', [
            'class' => $class,
            'lecturers' => $lecturers
        ]);
    }
}