<?php

namespace App\Http\Controllers;

use App\Tags;
use Illuminate\Http\Request;

use App\Http\Requests;
class TagController extends Controller
{
    public function index()
    {
        return Tags::all();
    }

    public function store(Request $request)
    {
        return Tags::create($request->all());
    }

    public function show($id)
    {
        return Tags::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        Tags::findOrFail($id)->update($request->all());

        return response()->json($request->all());

    }

    public function destroy($id)
    {
        return Tags::destroy($id);
    }

}
