<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Category;
class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        return Category::create($request->all());
    }

    public function show($id)
    {
        return Category::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        Category::findOrFail($id)->update($request->all());

        return response()->json($request->all());

    }

    public function destroy($id)
    {
        return Category::destroy($id);
    }

}
