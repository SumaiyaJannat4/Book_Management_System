<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index(Request $request)
    {   
        $query = Book::with('publisher');
    
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('genre', 'like', "%{$search}%")
                  ->orWhere('published_year', 'like', "%{$search}%");
            })
            ->orWhereHas('publisher', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }
    
        $sort = $request->input('sort');
        $direction = $request->input('direction', 'asc');
    
        if ($sort && in_array($sort, ['title', 'author', 'published_year', 'genre'])) {
            $query->orderBy($sort, $direction);
        } else {
            $query->orderBy('id', 'asc'); // default sort
        }
    
        $books = $query->paginate(8)->withQueryString();
        $publishers = \App\Models\Publisher::all();
    
        return view('welcome', compact('books', 'sort', 'direction', 'publishers'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $publishers = Publisher::all(); // Fetch all publishers
       return view('create', compact('publishers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([ 
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
        'genre' => 'nullable|string|max:255',
        'publisher_name' => 'nullable|exists:publishers,name',]);
        $book = new Book;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->published_year= $request->published_year;
        $book->genre = $request->genre;
        $book->publisher_id = $request->publisher_id;
        $book->save();
        return redirect()->route('dashboard')->with('success', 'Book added successfully.');
    }

   
    public function update(Request $request, $id){
    try {
       
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'genre' => 'nullable|string|max:255',
            'publisher_id' => 'nullable|exists:publishers,id',
        ]);

    
        $book = Book::findOrFail($id);
        $book->title = $validated['title'];
        $book->author = $validated['author'];
        $book->published_year = $validated['published_year'];
        $book->genre = $validated['genre'];
        $book->publisher_id = $validated['publisher_id'];
        $book->save();

        
        flash()->success('Book has been updated!');
        return redirect()->route('dashboard');

    } catch (\Illuminate\Validation\ValidationException $e) {
       
        return redirect()
        ->back()
        ->withErrors($e->validator)
        ->withInput()
        ->with('editing_book_id', $id)
        ->with('editing_book_data', Book::find($id)); 
    
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book, $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        flash()->success('Book has been deleted!');
        return redirect()->route('dashboard');
    }
}
