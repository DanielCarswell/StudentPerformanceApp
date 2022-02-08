<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Classe;
use App\Models\Assignment;

class AssignmentController extends Controller
{
    //
    public function class_assignments(int $class_id) {
        $assignments = Assignment::where('class_id', '=', $class_id)->paginate(8);
        return view("admin.assignments.class_index");
    }
}
