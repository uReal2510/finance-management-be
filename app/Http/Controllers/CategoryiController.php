<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoryi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryiController extends Controller
{
    public function index()
    {
        $categoriesi = Categoryi::all();
        return response()->json($categoriesi, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $category = Categoryi::create($request->all());
        return response()->json($categoryi, 201);
    }

    public function show($id)
    {
        $categoryi = Categoryi::findOrFail($id);
        return response()->json($categoryi, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string',
        ]);

        $categoryi = Categoryi::findOrFail($id);
        $categoryi->update($request->all());
        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $categoryi = Categoryi::findOrFail($id);
        $categoryi->delete();
        return response()->json(null, 204);
    }
}
