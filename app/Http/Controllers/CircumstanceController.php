<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\Circumstance;
use App\Models\Tables\Circumstance_link;

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

    public function create(Request $request) {
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

        $circumstances = \DB::table('circumstances')->where('circumstances.id', '!=', $request->circumstance_id)->get();

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

    public function links(Circumstance $circumstance) {
        return view('admin.circumstances.helpful_links', [
            'circumstance' => $circumstance
        ]);
    }

    public function add_link(Request $request) {
        //Checking circumstance credentials are valid.
        $credentials = $request->validate([
            'link' => ['required', 'max:255']
        ]);

        $circumstance = Circumstance::with(['circumstance_links'])->where('circumstances.id', $request->circumstance_id)->first();

        foreach($circumstance->circumstance_links as $link) {
            if($request->link == $link->link) return back()->withErrors([
                'link' => 'This link has already been added.'
            ]);
        }

        //Adding circumstance to database if valid credentials.
        if ($credentials) {
            DB::table('circumstance_links')->insert([
                'circumstance_id' => $request->circumstance_id,
                'link' => $request->link,
                'id_of_user_added_by' => auth()->user()->id
            ]);
        }

        return back();
    }

    public function delete_link(Request $request) {
        //Add policy
        $link = Circumstance_link::where('circumstance_id', $request->circumstance_id)
        ->where('link', $request->link_l)
        ->delete();

        return back();
    }
}
