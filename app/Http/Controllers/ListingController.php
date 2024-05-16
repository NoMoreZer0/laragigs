<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListingRequest;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function index() {
        $listings = Listing::latest()
            -> filter(request(['tag', 'search']))
            -> paginate(5);
        return view('listings.index', compact('listings'));
    }

    public function show($id) {
        return view('listings.show', ['listing' => Listing::find($id)]);
    }

    public function create() {
        return view('listings.create');
    }

    public function store(ListingRequest $request) {
        $fields = $request->validated();
        if ($request -> hasFile('logo')) {
            $fields['logo'] = $request -> file('logo') -> store('logos', 'public');
        }
        $fields['user_id'] = auth() -> id();
        Listing::create($fields);
        return redirect("/") -> with('message', 'Listing created!');
    }

    public function edit(Listing $listing) {
        return view('listings.edit', compact('listing'));
    }

    public function update(ListingRequest $request, Listing $listing) {
        if ($listing -> user_id != auth() -> id()) {
            abort(403, 'Unauthorized action.');
        }

        $fields = $request->validated();
        if ($request -> hasFile('logo')) {
            $fields['logo'] = $request -> file('logo') -> store('logos', 'public');
        }
        $listing -> update($fields);
        return back() -> with('message', 'Listing updated!');
    }

    public function destroy(Listing $listing) {
        if ($listing -> user_id != auth() -> id()) {
            abort(403, 'Unauthorized action.');
        }
        $listing -> delete();
        return redirect("/") -> with('message', 'Listing deleted!');
    }

    public function manage(Request $request) {
        $listings = auth() -> user() -> listings() -> get();
        return view('listings.manage', compact('listings'));
    }
}
