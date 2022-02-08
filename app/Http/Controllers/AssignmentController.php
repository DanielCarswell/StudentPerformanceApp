<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Classe;
use App\Models\Assignment;

class AssignmentController extends Controller
{
    public function create() {
        return view('admin.assignments.create_assignment');
    }

    public function class_assignments(int $class_id) {
        $assignments = DB::table('classes')
        ->select('assignments.name', 'assignments.class_worth', 'classes.name AS class_name')
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
