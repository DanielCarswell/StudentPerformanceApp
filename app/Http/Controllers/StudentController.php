<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class StudentController extends Controller
{
    public function index()
    {
        $students1 = User::with(['classes'])
        ->where('id', '!=', 1)
        ->whereIn('id', range(2,11))
        ->paginate(8);

        foreach($students1 as $student) {
            $student->average_grade = (\DB::table('user_class')
            ->select(\DB::raw('round(AVG(CAST(user_class.grade as numeric)), 1) as average_grade'))
            ->where('user_class.user_id', '=', $student->id)
            ->groupBy('user_class.user_id')
            ->get()[0]->average_grade);
        }

        $students2 = User::with(['classes'])
        ->where('id', '!=', 1)
        ->whereIn('id', range(12,21))
        ->get();

        $students3 = User::with(['classes'])
        ->where('id', '!=', 1)
        ->whereIn('id', range(22,31))
        ->get();

        $students4 = User::with(['classes'])
        ->where('id', '!=', 1)
        ->whereIn('id', range(32,41))
        ->get();

        return view('students.index', [
            'students1' => $students1,
            'students2' => $students2,
            'students3' => $students3,
            'students4' => $students4
        ]);
    }
}
