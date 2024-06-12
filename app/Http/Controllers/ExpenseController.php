<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExpenseController extends Controller
{
    public function index()
    {
        try {
            $userId = Auth::id();
            Log::info('Fetching expenses for user ID: ' . $userId);
            
            $expenses = Expense::where('user_id', $userId)->get();
            Log::info('Expenses: ' . $expenses);
            return response()->json($expenses);
        } catch (\Exception $e) {
            Log::error('Error fetching expenses: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch expenses'], 500);
        }
    }

    public function store(Request $request)
    {

        try{
            $userId = Auth::id();
            $kategori = $request->input('kategori');

            $category = Category::where('name', $validated['kategori'])->first();
            
            if (!$category) {
                return response()->json(['error' => 'Category not found'], 404);
            }

            $categoryId = $category->id;

            $expense = Expense::create([
                'user_id' => $userId,
                'tanggal' => $request->input('tanggal'),
                'kategori' => $request->input('kategori'),
                'deskripsi' => $request->input('deskripsi'),
                'jumlah' => $request->input('jumlah'),
                'category_id' => $categoryId,
            ]);
            return response()->json(['message' => 'expense created successfully!'], 201);
        } catch (\Exception $e) {
            Log::error('Error creating expense: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create expense'], 500);
        }
    }

    public function show($id)
    {
        $expense = Expense::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return response()->json($expense, 200);
    }

    public function update(Request $request, $id)
    {
        
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], 404);
        }

        $expense->tanggal = $request->input('tanggal');
        $expense->kategori = $request->input('kategori');
        $expense->deskripsi = $request->input('deskripsi');
        $expense->jumlah = $request->input('jumlah');

        $expense->save();

        return response()->json(['message' => 'Expense updated successfully', 'expense' => $expense], 200);
    }

    public function destroy($id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], 404);
        }

        $expense->delete();

        return response()->json(['message' => 'Expense deleted successfully'], 200);
    }
}
