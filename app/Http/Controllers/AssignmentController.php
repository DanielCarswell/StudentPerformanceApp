<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Classe;
use App\Models\Assignment;

class AssignmentController extends Controller
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
    public function add(Request $request) {
        //Checking assignment credentials are valid.
        $credentials = $request->validate([
            'assignmentname' => ['required', 'max:255'],
            'classworth' => ['required', 'numeric']
        ]); 

        //Make assignmentname unique for a class ...

        if(!$request->isexam)
            $request->isexam = false;

        //Adding assignment to database if valid credentials.
        if ($credentials) {
            DB::table('assignments')->insert([
                'name' => $request->assignmentname,
                'class_worth' => $request->classworth,
                'is_exam' => $request->isexam,
                'class_id' => $request->class_id
            ]);

            $assignmentid = 0;
            $assignments = DB::table('assignments')->get();

            foreach($assignments as $assignment) {
                $assignmentid = $assignment->id;
            }

            $class = Classe::with(['students'])->find($request->class_id);

            foreach($class->students as $student)
                DB::table('student_assignment')->insert([
                    'user_id' => $student->id,
                    'assignment_id' => $assignmentid,
                    'class_id' => $request->class_id
                ]);
        }

        return redirect()->route('class_assignments', $request->class_id);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function create(int $class_id) {
        return view('admin.assignments.create_assignment', [
            'class_id' => $class_id
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function delete(int $class_id, int $assignment_id) {
        $assignment = Assignment::find($assignment_id);

        if($assignment->is_exam == TRUE)
            $assignment->exam = "Yes";
        else 
            $assignment->exam = "No";

        return view('admin.assignments.delete', [
            'class_id' => $class_id,
            'assignment' => $assignment
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function destroy(int $assignment_id, int $class_id) {
        $assignment = Assignment::find($assignment_id);
        $assignment->delete();
        return redirect()->route('class_assignments', $class_id);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function edit(int $assignment_id, int $class_id){
        $assignment = Assignment::find($assignment_id);

        return view('admin.assignments.edit', [
            'assignment' => $assignment,
            'class_id' => $class_id
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function modify(Request $request){
        //Checking assignment credentials are valid.
        $credentials = $request->validate([
            'assignmentname' => ['required', 'max:255'],
            'classworth' => ['required', 'numeric']
        ]); 

        if(!$request->isexam)
            $request->isexam = FALSE;

        //Adding assignment to database if valid credentials.
        if ($credentials) {
            DB::table('assignments')
            ->where('assignments.id', '=', $request->assignment_id)
            ->update([
                'name' => $request->assignmentname,
                'class_worth' => $request->classworth,
                'is_exam' => $request->isexam
            ]);
        }

        return redirect()->route('class_assignments', $request->class_id);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function class_assignments(int $class_id) {
        $assignments = DB::table('classes')
        ->select('assignments.id', 'assignments.name', 'assignments.class_worth', 'classes.name AS class_name')
        ->from('assignments')
        ->join('classes', 'classes.id', '=', 'assignments.class_id')
        ->where('classes.id', $class_id)
        ->orderBy('assignments.class_worth')
        ->paginate(8);

        $class = Classe::where('id', $class_id)->first();

        return view("admin.assignments.class_index", [
            'assignments' => $assignments,
            'class' => $class
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function search_assignments(Request $request) {
        $q = $request->q;
        $class_id = $request->class_id;

        $assignments = DB::table('classes')
        ->select('assignments.name', 'assignments.class_worth', 'classes.name AS class_name')
        ->from('assignments')
        ->join('classes', 'classes.id', '=', 'assignments.class_id')
        ->where('classes.id', '=', $class_id)
        ->where('assignments.name', 'LIKE', '%' . $q . '%')
        ->paginate(8);

        $class = Classe::where('id', $class_id)->first();

        return view('admin.assignments.class_index', [
            'assignments' => $assignments,
            'class' => $class
        ]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function update_mark(Request $request){
        $credentials = $request->validate([
            'percent' => ['numeric']
        ]);

        if($credentials && $request->percent >= 0 && $request->percent <= 100)
            DB::table('student_assignment')
            ->where('assignment_id', '=', $request->assignment_id)
            ->where('class_id', '=', $request->class_id)
            ->where('user_id', '=', $request->student_id)
            ->update([
                'percent' => $request->percent
            ]);

        $assignment = Assignment::find($request->assignment_id);
        $class = Classe::find($request->class_id);

        $this->update_student_grades($request->student_id);

        return redirect()->route('assignment_grades', [$assignment, $class]);
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function update_student_grades(int $student_id) {
        $classes = \DB::table('classes')
        ->select('classes.id', 'classes.name', 'student_class.grade', 'student_class.attendance')
        ->from('classes')
        ->join('student_class', 'student_class.class_id', '=', 'classes.id')
        ->join('users', 'users.id', '=', 'student_class.student_id')
        ->where('users.id', $student_id)
        ->get();

        foreach($classes as $class) {
            $assignments = \DB::table('assignments')
            ->select('assignments.id', 'student_assignment.percent', 'assignments.class_worth')
            ->from('assignments')
            ->join('student_assignment', 'student_assignment.assignment_id', '=', 'assignments.id')
            ->join('users', 'users.id', '=', 'student_assignment.user_id')
            ->join('classes', 'student_assignment.class_id', '=', 'classes.id')
            ->where('users.id', $student_id)
            ->where('classes.id', $class->id)
            ->get();

            $class_grade = 0.0;
            $total_class_worth = 0.0;

            foreach($assignments as $assignment) {
                if($assignment->percent == 0)
                    continue;
                $total_class_worth += $assignment->class_worth;
                $class_grade += ($assignment->percent * ($assignment->class_worth/100));
            }

            if($total_class_worth != 0)
                \DB::table('student_class')
                    ->where('class_id', $class->id)
                    ->where('student_id', $student_id)
                    ->update([
                        'grade' => (($class_grade / $total_class_worth) * 100)
                    ]);
        }

        return;
    }

    /**
    *
    * @param 
    * @return view     
    */
    public function upload(Request $request) {
        return view('classes.upload_assignment_grades', [
            'class_id' => $request->class_id,
            'assignment_id' => $request->assignment_id
        ]);
    }
}
