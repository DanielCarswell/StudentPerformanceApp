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
    * Adds Assignment to Database if valid input.
    *
    * @param \Illuminate\Http\Request request
    * @return view     
    */
    public function add(Request $request) {
        //Checking assignment credentials are valid.
        $credentials = $request->validate([
            'assignmentname' => ['required', 'max:255'],
            'classworth' => ['required', 'numeric']
        ]);

        //If no isexam then initalize False.
        if(!$request->isexam)
            $request->isexam = FALSE;

        //Adding assignment to database if valid credentials.
        if ($credentials) {
            DB::table('assignments')->insert([
                'name' => $request->assignmentname,
                'class_worth' => $request->classworth,
                'is_exam' => $request->isexam,
                'class_id' => $request->class_id
            ]);

            //Initializing variables.
            $assignmentid = 0;
            $assignments = DB::table('assignments')->get();

            //Getting id of last assignment in database as it is the one just added.
            foreach($assignments as $assignment) {
                $assignmentid = $assignment->id;
            }

            //Get class with students for loop.
            $class = Classe::with(['students'])->find($request->class_id);

            //Add assignment to all students in the class.
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
    * Returns create page for Assignments.
    *
    * @param int class_id
    * @return view     
    */
    public function create(int $class_id) {
        return view('admin.assignments.create_assignment', [
            'class_id' => $class_id
        ]);
    }

    /**
    * Initializes models for delete assignment view.
    *
    * @param int class_id
    * @param int assignment_id
    * @return view     
    */
    public function delete(int $class_id, int $assignment_id) {
        //Get assignment by id.
        $assignment = Assignment::find($assignment_id);

        //Confirm if assignment is an exam or not, set exam variable Yes or no.
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
    * Deletes the assignment which cascade deletes student assignments.
    *
    * @param int assignment_id
    * @param int class_id
    * @return route.redirect     
    */
    public function destroy(int $assignment_id, int $class_id) {
        $assignment = Assignment::find($assignment_id);
        $assignment->delete();
        return redirect()->route('class_assignments', $class_id);
    }

    /**
    * Passes model and class_id to Assignment Edit Page.
    *
    * @param int assignment_id
    * @param int class_id
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
    * Edits the assignment in Database.
    *
    * @param \Illuminate\Http\Request request
    * @return view     
    */
    public function modify(Request $request){
        //Checking assignment credentials are valid.
        $credentials = $request->validate([
            'assignmentname' => ['required', 'max:255'],
            'classworth' => ['required', 'numeric']
        ]); 

        //If no isexam then initalize False.
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
    * Gets all Assignments ordered by Class worth and class model for view.
    *
    * @param int class_id
    * @return view     
    */
    public function class_assignments(int $class_id) {
        //Gets assignment id, name, class_worth and the Class name for all assignments in passed class.
        $assignments = DB::table('classes')
        ->select('assignments.id', 'assignments.name', 'assignments.class_worth', 'classes.name AS class_name')
        ->from('assignments')
        ->join('classes', 'classes.id', '=', 'assignments.class_id')
        ->where('classes.id', $class_id)
        ->orderBy('assignments.class_worth')
        ->paginate(8);

        //Gets class model for view.
        $class = Classe::where('id', $class_id)->first();

        return view("admin.assignments.class_index", [
            'assignments' => $assignments,
            'class' => $class
        ]);
    }

    /**
    * Searches Assignment names and passes filtered data to view.
    *
    * @param \Illuminate\Http\Request request
    * @return view     
    */
    public function search_assignments(Request $request) {
        //Initialize local variables.
        $q = $request->q;
        $class_id = $request->class_id;

        //Gets all assignment names, class worth and name of class where assignment belongs to passed class in Request.
        $assignments = DB::table('classes')
        ->select('assignments.name', 'assignments.class_worth', 'classes.name AS class_name')
        ->from('assignments')
        ->join('classes', 'classes.id', '=', 'assignments.class_id')
        ->where('classes.id', '=', $class_id)
        ->where('assignments.name', 'LIKE', '%' . $q . '%')
        ->paginate(8);

        //Gets class model for view.
        $class = Classe::where('id', $class_id)->first();

        return view('admin.assignments.class_index', [
            'assignments' => $assignments,
            'class' => $class
        ]);
    }

    /**
    * Updates a Students Assignment mark.
    *
    * @param \Illuminate\Http\Request request
    * @return route.redirect     
    */
    public function update_mark(Request $request){
        //Checks percent is numeric and not letters.
        $credentials = $request->validate([
            'percent' => ['numeric']
        ]);

        //If credentials are valid and percent is an appropriate number updates percent for students assignment in database.
        if($credentials && $request->percent >= 0 && $request->percent <= 100)
            DB::table('student_assignment')
            ->where('assignment_id', '=', $request->assignment_id)
            ->where('class_id', '=', $request->class_id)
            ->where('user_id', '=', $request->student_id)
            ->update([
                'percent' => $request->percent
            ]);

        //Get assignment and class model by id for view.
        $assignment = Assignment::find($request->assignment_id);
        $class = Classe::find($request->class_id);

        //Updates the students grade for the entire class.
        $this->update_student_grades($request->student_id);

        return redirect()->route('assignment_grades', [$assignment, $class]);
    }

    /**
    * Upgrades students grade for the full class by calculating total grade by all assignments
    * meaning if a student has done 1 assignment and got 50%, their grade will be 50% or an assignment
    * with 50% and one with 100% 20% class worth on both then 75% class grade.
    *
    * @param int student_id
    * @return to.method.call  
    */
    public function update_student_grades(int $student_id) {
        //Gets all of the students classes.
        $classes = \DB::table('classes')
        ->select('classes.id', 'classes.name', 'student_class.grade', 'student_class.attendance')
        ->from('classes')
        ->join('student_class', 'student_class.class_id', '=', 'classes.id')
        ->join('users', 'users.id', '=', 'student_class.student_id')
        ->where('users.id', $student_id)
        ->get();

        //For all of the students classes.
        foreach($classes as $class) {
            //Gets all students assignments for the class.
            $assignments = \DB::table('assignments')
            ->select('assignments.id', 'student_assignment.percent', 'assignments.class_worth')
            ->from('assignments')
            ->join('student_assignment', 'student_assignment.assignment_id', '=', 'assignments.id')
            ->join('users', 'users.id', '=', 'student_assignment.user_id')
            ->join('classes', 'student_assignment.class_id', '=', 'classes.id')
            ->where('users.id', $student_id)
            ->where('classes.id', $class->id)
            ->get();

            //Initializing local varaibles.
            $class_grade = 0.0;
            $total_class_worth = 0.0;

            //for all assignments, add class_worth and class_grade.
            foreach($assignments as $assignment) {
                if($assignment->percent == 0)
                    continue;
                $total_class_worth += $assignment->class_worth;
                $class_grade += ($assignment->percent * ($assignment->class_worth/100));
            }

            //Update class grade by total class worth for current overall grade.
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
    * Passes class_id and assignment_id to uploading assignment grades.
    *
    * @param \Illuminate\Http\Request request
    * @return view     
    */
    public function upload(Request $request) {
        return view('classes.upload_assignment_grades', [
            'class_id' => $request->class_id,
            'assignment_id' => $request->assignment_id
        ]);
    }
}
