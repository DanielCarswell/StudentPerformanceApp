<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\Circumstance;
use App\Models\Tables\Circumstance_link;

class CircumstanceController extends Controller
{
    /**
    * Ensures user authentication to access Controller.  
    */
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    /**
    * Gets all circumstances for view.
    *
    * @return view     
    */
    public function index() {
        //Get all circumstances and helpful links.
        $circumstances = Circumstance::with(['circumstance_links'])->paginate(8);

        return view('admin.circumstances.index', [
            'circumstances' => $circumstances
        ]);
    }
    
    /**
    * Returns add circumstance view.
    *
    * @return view     
    */
    public function add() {
        return view('admin.circumstances.add_circumstance');
    }

    /**
    * Creates new Circumstance in Database.
    *
    * @param \Illuminate\Http\Request request
    * @return view     
    */
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

        return redirect()->route('circumstances');
    }

    /**
    * Returns Circumstance edit page with circumstance model.
    *
    * @param \App\Models\Circumstance circumstance
    * @return view     
    */
    public function edit(Circumstance $circumstance) {
        return view('admin.circumstances.edit', [
            'circumstance' => $circumstance
        ]);
    }

    /**
    * Updates circumstance in the Database.
    *
    * @param \Illuminate\Http\Request request
    * @return view     
    */
    public function update(Request $request) {
        //Checking circumstance credentials are valid.
        $credentials = $request->validate([
            'name' => ['required', 'max:255'],
            'information' => ['required', 'max:10000']
        ]); 

        //Gets all circumstances other than the one updating.
        $circumstances = \DB::table('circumstances')->where('circumstances.id', '!=', $request->circumstance_id)->get();

        //Confirming no other circumstance has the name entered, returns an error if it does.
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

        return redirect()->route('circumstances');
    }

    /**
    * Returns Circumstance delete view with circumstance model.
    *
    * @param \App\Models\Classe class
    * @return view     
    */
    public function delete(Circumstance $circumstance) {
        return view('admin.circumstances.delete', [
            'circumstance' => $circumstance
        ]);
    }

    /**
    * Deletes circumstance.
    *
    * @param \App\Models\Circumstance circumstance
    * @return view     
    */
    public function destroy(Circumstance $circumstance) {
        $circumstance->delete();
        return $this->index();
    }

    /**
    * Returns view for Circumstance helpful links.
    *
    * @param \App\Models\Circumstance circumstance
    * @return view     
    */
    public function links(Circumstance $circumstance) {
        return view('admin.circumstances.helpful_links', [
            'circumstance' => $circumstance
        ]);
    }

    /**
    * Adds circumstance help link to Database.
    *
    * @param \Illuminate\Http\Request request
    * @return back error message
    * @return back.to.previous.view     
    */
    public function add_link(Request $request) {
        //Checking link credentials are valid.
        $credentials = $request->validate([
            'link' => ['required', 'max:255', 'url']
        ]);

        //Get circumstance from database.
        $circumstance = Circumstance::with(['circumstance_links'])->where('circumstances.id', $request->circumstance_id)->first();

        //If link is already associated with circumstance, return error message.
        foreach($circumstance->circumstance_links as $link) {
            if($request->link == $link->link) return back()->withErrors([
                'link' => 'This link has already been added.'
            ]);
        }

        //Adding circumstance help link to database if valid credentials.
        if ($credentials) {
            DB::table('circumstance_links')->insert([
                'circumstance_id' => $request->circumstance_id,
                'link' => $request->link,
                'id_of_user_added_by' => auth()->user()->id
            ]);
        }

        return back();
    }

    /**
    * Deletes help link association to Circumstance.
    *
    * @param  \Illuminate\Http\Request request
    * @return back.to.previous.view     
    */
    public function delete_link(Request $request) {
        $link = Circumstance_link::where('circumstance_id', $request->circumstance_id)
        ->where('link', $request->link_l)
        ->delete();

        return back();
    }
}
