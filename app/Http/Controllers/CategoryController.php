<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::where('user_id', Auth::id())->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $category = new Category([
            'name' => $request->name,
            'user_id' => Auth::id(),
        ]);

        $category->save();

        return response()->json(['message' => 'Category created successfully!'], 201);
    }

    public function show($id)
    {
        $category = Category::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return response()->json($category, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $category->name = $request->name;
        $category->save();

        return response()->json(['message' => 'Category updated successfully!']);
    }

    public function destroy($id)
    {
        $category = Category::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully!']);
    }
}
