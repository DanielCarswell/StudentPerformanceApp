<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Circumstance;

class CircumstanceController extends Controller
{
    public function index() {
        $circumstances = Circumstance::with(['circumstance_links'])->paginate(8);

        return view('admin.circumstances.index', [
            'circumstances' => $circumstances
        ]);
    }
    
    public function add() {
        return view('admin.circumstances.add_circumstance');
    }

    public function create() {
        //Checking circumstance credentials are valid.
        $credentials = $request->validate([
            'name' => ['required', 'unique:circumstances', 'max:255'],
            'information' => ['required', 'max:10000']
        ]); 

        //Adding circumstance to database if valid credentials.
        if ($credentials) {
            DB::table('circumstances')->insert([
                'name' => $request->name,
                'information' => $request->information
            ]);
        }

        return $this->index();
    }

    public function edit(Circumstance $circumstance) {
        return view('admin.circumstances.edit', [
            'circumstance' => $circumstance
        ]);
    }

    public function update(Request $request) {
        //Checking circumstance credentials are valid.
        $credentials = $request->validate([
            'name' => ['required', 'max:255'],
            'information' => ['required', 'max:10000']
        ]); 

        $circumstance = \DB::table('circumstances')->where('circumstances.id', '!=', $request->circumstance_id)->get();

        foreach($circumstances as $cirumstance) {
            if($request->name != $circumstance->name) {}
            else return back()->withErrors([
                'name' => 'This circumstance name is already in use.'
            ]);
        }

        //Adding circumstance to database if valid credentials.
        if ($credentials) {
            DB::table('circumstances')
            ->where('circumstances.id', '=', $request->circumstance_id)
            ->update([
                'name' => $request->name,
                'information' => $request->information
            ]);
        }

        return $this->index();
    }

    public function delete(Circumstance $circumstance) {
        return view('admin.circumstances.delete', [
            'circumstance' => $circumstance
        ]);
    }

    public function destroy(Circumstance $circumstance) {
        //Add policy

        $circumstance->delete();
        return $this->index();
    }
}
