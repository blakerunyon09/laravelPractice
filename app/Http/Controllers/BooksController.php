<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BooksController extends Controller
{
    public function index()
    {
        $books = Book::all();

        return response($books, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'page' => 'numeric'
        ]);

        $book = new Book;
        $book->name = $request->name;
        $book->page = $request->page;
        $book->save();

        return response($book, 201);
    }

    public function show($id)
    {
        $book = Book::find($id);

        return response($book, 200);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        $request->validate([
            'name' => 'required',
            'page' => ['numeric', Rule::requiredIf($book->age)]
        ]);

        $book->name = $request->name;
        $book->page = $request->page;
        $book->save();

        return response($book, 200);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();

        response($book, 204);
    }
}
