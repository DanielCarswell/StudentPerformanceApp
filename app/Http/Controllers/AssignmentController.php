<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Classe;
use App\Models\Assignment;

class AssignmentController extends Controller
{
    public function add(Request $request) {
        //Checking assignment credentials are valid.
        $credentials = $request->validate([
            'assignmentname' => ['required', 'max:255'],
            'classworth' => ['required', 'numeric']
        ]); 

        //Adding assignment to database if valid credentials.
        if ($credentials) {
            DB::table('assignments')->insert([
                'name' => $request->assignmentname,
                'class_worth' => $request->classworth,
                'is_exam' => $request->isexam,
                'class_id' => $request->class_id
            ]);
        }

        return $this->class_assignments($request->class_id);
    }

    public function create(int $class_id) {
        return view('admin.assignments.create_assignment', [
            'class_id' => $class_id
        ]);
    }

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

    public function destroy(int $assignment_id, int $class_id) {
        $assignment = Assignment::find($assignment_id);
        $assignment->delete();
        return $this->class_assignments($class_id);
    }

    public function edit(int $assignment_id, int $class_id){
        $assignment = Assignment::find($assignment_id);

        return view('admin.assignments.edit', [
            'assignment' => $assignment,
            'class_id' => $class_id
        ]);
    }

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

        return $this->class_assignments($request->class_id);
    }

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
}
