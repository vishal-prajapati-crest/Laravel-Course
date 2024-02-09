<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter','');

        $books = Book::when($title, fn($query,$title)=> $query->title($title));


        // if ($filter === '' || $filter === null) {
        //     $books = $books->withAvg('reviews','rating')->withCount('reviews')->latest();

        // }elseif ($filter === 'popular_last_month') {
        //     $books = $books->popularLastMonth();
            
        // }elseif($filter === 'popular_last_6month'){
        //     $books = $books->popularLast6Months();
            
        // }elseif($filter === 'highest_rated_last_month'){
        //     $books = $books->highestratedLastMonth();
            
        // }
        // elseif($filter === 'highest_rated_last_6month'){
        //     $books = $books->highestratedLast6Months();
            
        // }
        // else{
        //     $books = $books->withAvg('reviews','rating')->withCount('reviews');
        // }

        $books = match($filter){
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6month' => $books->popularLast6Months(),
            'highest_rated_last_month' => $books->highestratedLastMonth(),
            'highest_rated_last_6month' => $books->highestratedLast6Months(),
            default => $books->withAvg('reviews','rating')->withCount('reviews')->latest()
        };

        $books = $books->get();

        //cache the result for one hour
        // $cacheKey = 'books:' . $filter . ':' . $title;
        // $books = cache()->remember($cacheKey,3600,fn()=>$books->get());




        return view('books.index', ['books' => $books
        ]) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return the view of create-book.blade.php
        return view('books.create-book');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'author' => 'required'
        ]);

        $book = Book::create($data);
        return redirect()->route('books.show',['book' => $book]);

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
        $book = Book::with(['reviews' => fn($query) => $query->latest()])->withCount('reviews')->withAvg('reviews','rating')->findOrFail($id);

        $cacheKey = 'book:' . $book->id;
        $book = cache()->remember($cacheKey,3600,fn()=>$book);


        return view('books.book', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
