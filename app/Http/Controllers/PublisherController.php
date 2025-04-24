<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller{


    public function index(Request $request)
{
    $query = Publisher::query();

    // Handle search functionality 
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%');
        });
    }

    // Handle sorting functionality
    if ($request->has('sort') && $request->has('direction')) {
        $query->orderBy($request->sort, $request->direction);
    } else {
        // Default sorting by ID in ascending order
        $query->orderBy('id', 'asc');
    }

    // Paginate the results
    $publishers = $query->paginate(5);

    return view('publishers.index', compact('publishers'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('publishers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:publishers,name',
            'email' => 'required|email|max:255|unique:publishers,email',
        ]);

        Publisher::create($validated);

        return redirect()->route('publishers.index')->with('success', 'Publisher added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $publisher = Publisher::findOrFail($id);
        return view('publishers.edit', ['publisher' => $publisher]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $publisher = Publisher::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:publishers,name,' . $publisher->id,
            'email' => 'required|email|max:255|unique:publishers,email',
        ]);

        $publisher->update($validated);

        return redirect()->route('publishers.index')->with('success', 'Publisher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $publisher = Publisher::findOrFail($id);
        $publisher->delete();

        return redirect()->route('publishers.index')->with('success', 'Publisher deleted successfully.');
    }
}
