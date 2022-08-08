<?php

namespace App\Http\Controllers;

use App\Models\Gig;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class GigController extends Controller
{   
    // list all gigs
    public function index() {
        return view('gigs.index', [
            'gigs' => Gig::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    // show single gig
    public function show(Gig $gig) {
        return view('gigs.show', [
            'gig' => $gig
        ]);
    }

    public function create() {
        return view('gigs.create');
    }

    public function store(Request $request) {
        $fields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('gigs', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        $file_loc='';
        if($request->hasFile('logo')) {
            $file_loc = $request->file('logo')->store('logos', 'public');
            $fields['logo'] = $file_loc;
        }

        $fields['user_id'] = auth()->id();

        Gig::create($fields);
        
        return redirect('/')->with('message', 'Gig created successfully!');
    }

    public function edit (Gig $gig) {
        return view('gigs.edit', ['gig' => $gig]);
    }

    public function update (Request $request, Gig $gig) {

        if($gig->user_id != auth()->id()) {
            abort(401, 'Unauthorized action');
        }

        $fields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        $file_loc='';
        if($request->hasFile('logo')) {
            $file_loc = $request->file('logo')->store('logos', 'public');
            $fields['logo'] = $file_loc;
        }
        $gig->update($fields);
        
        return back()->with('message', 'Gig updated successfully!');
    }

    public function destroy (Gig $gig) {

        if($gig->user_id != auth()->id()) {
            abort(401, 'Unauthorized action');
        }

        $gig->delete();
        return redirect('/')->with('message', 'Gig deleted succesfully');
    }

    public function manage() {
        return view('gigs.manage', ['gigs' => auth()->user()->gigs()->get()]);
    }
}
