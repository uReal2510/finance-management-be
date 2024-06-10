<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\tipe;
use Illuminate\Http\Request;

class TipeController extends Controller
{
    public function index()
    {
        $tipes = tipe::all();
        return response()->json($tipes, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $tipe = tipe::create($request->all());
        return response()->json($tipe, 201);
    }

    public function show($id)
    {
        $tipe = tipe::findOrFail($id);
        return response()->json($tipe, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string',
        ]);

        $tipe = tipe::findOrFail($id);
        $tipe->update($request->all());
        return response()->json($tipe, 200);
    }

    public function destroy($id)
    {
        $tipe = tipe::findOrFail($id);
        $tipe->delete();
        return response()->json(null, 204);
    }
}
