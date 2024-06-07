<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $expense = Expense::all();
        return response()->json($expense, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'tipe' => 'required|string',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'jumlah' => 'required|numeric',
        ]);

        $expense = Expense::create([
            'tanggal' => $request->tanggal,
            'tipe' => $request->tipe,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'jumlah' => $request->jumlah,
            'user_id' => Auth::id(),
        ]);

        $expense->save();
        
        return response()->json(['message' => 'Category created successfully!'], 201);
    }

    public function show($id)
    {
        $expense = Expense::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return response()->json($category, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'tipe' => 'required|string',
            'kategori' => 'required|string',
            'deskripsi' => 'required|string',
            'jumlah' => 'required|numeric',
        ]);

        $expense = Expense::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $expense->name = $request->name;
        $expense->save();

        return response()->json(['message' => 'Expense updated successfully!']);
    }

    public function destroy($id)
    {
        $expense = Expense::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $expense->delete();

        return response()->json(['message' => 'Expense deleted successfully!']);
    }
}
