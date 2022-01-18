<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PublishersController extends Controller
{
    public function index()
    {
        $publishers = Publisher::all();

        return response($publishers, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'publishing_house' => 'required|alpha_num',
            'num_of_employees' => 'numeric'
        ]);

        $publisher = new Publisher;
        $publisher->publishing_house = $request->publishing_house;
        $publisher->num_of_employees = $request->num_of_employees;

        $publisher->save();

        return response($publisher, 201);
    }

    public function show($id)
    {
        $publisher = Publisher::find($id);

        return response($publisher, 200);
    }

    public function update(Request $request, $id)
    {
        $publisher = Publisher::find($id);
        $request->validate([
            'publishing_house' => 'required|alpha_num',
            'num_of_employees' => ['numeric', Rule::requiredIf($publisher->num_of_employees)]
        ]);

        $publisher->publishing_house = $request->publishing_house;
        $publisher->num_of_employees = $request->num_of_employees;

        $publisher->save();

        return response($publisher, 201);
    }

    public function destroy($id)
    {
        $publisher = Publisher::find($id);
        $publisher->delete();

        return response(null, 204);
    }
}
