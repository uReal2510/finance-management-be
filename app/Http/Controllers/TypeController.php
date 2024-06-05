<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::all();
        return response()->json($types, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $type = Type::create($request->all());
        return response()->json($type, 201);
    }

    public function show($id)
    {
        $type = Type::findOrFail($id);
        return response()->json($type, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string',
        ]);

        $type = Type::findOrFail($id);
        $type->update($request->all());
        return response()->json($type, 200);
    }

    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();
        return response()->json(null, 204);
    }
}
