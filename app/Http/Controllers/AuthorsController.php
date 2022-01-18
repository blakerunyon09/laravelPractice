<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthorsController extends Controller
{
    public function index()
    {
        $authors = Author::all();

        return response($authors, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha',
            'age' => 'numeric'
        ]);

        $author = new Author;
        $author->name = $request->name;
        $author->age = $request->age;
        $author->save();

        return response($author, 201);
    }

    public function show($id)
    {
        $author = Author::find($id);

        return response($author, 200);
    }

    public function update(Request $request, $id)
    {
        $author = Author::find($id);

        $request->validate([
            'name' => 'required|alpha',
            'age' => ['numeric', Rule::requiredIf($author->age)]
        ]);
        $author->name = $request->name;
        $author->age = $request->age;
        $author->save();

        return response($author, 200);
    }

    public function addPublisher($author, $publisher)
    {
        $author = Author::find($author);
        $publisher = Publisher::find($publisher);

        $author->publisher_id = $publisher->id;

        $author->save();

        return response($author);
    }

    public function returnPublisher($id)
    {
        $author = Author::where('id', $id)->with('publisher')->get();

        return response($author, 200);
    }

    public function destroy($id)
    {
        $author = Author::find($id);
        $author->delete();

        return response(null, 204);
    }
}
