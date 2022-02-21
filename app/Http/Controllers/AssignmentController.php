<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Role;
use App\Models\Classe;
use App\Models\Assignment;

class AssignmentController extends Controller
{
    public function add(Request $request) {
        return $this->class_assignments(1);
    }

    public function create(Role $role) {
        return view('admin.assignments.create_assignment', [
            'role' => $role
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

    public function destroy(int $assignment_id) {

    }

    public function class_assignments(int $class_id) {
        $assignments = DB::table('classes')
        ->select('assignments.id', 'assignments.name', 'assignments.class_worth', 'classes.name AS class_name')
        ->from('assignments')
        ->join('classes', 'classes.id', '=', 'assignments.class_id')
        ->where('classes.id', $class_id)
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
