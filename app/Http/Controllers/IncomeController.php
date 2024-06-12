<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IncomeController extends Controller
{
    public function index()
    {
        try {
            $userId = Auth::id();
            Log::info('Fetching incomes for user ID: ' . $userId);
            
            $incomes = Income::where('user_id', $userId)->get();
            Log::info('Incomes: ' . $incomes);
            return response()->json($incomes);
        } catch (\Exception $e) {
            Log::error('Error fetching incomes: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch incomes'], 500);
        }
    }

    public function store(Request $request)
    {
        try{
            $userId = Auth::id();
            $kategori = $request->input('kategori');

            $category = Category::where('name', $kategori)->first();
            
            if (!$category) {
                return response()->json(['error' => 'Category not found'], 404);
            }

            $categoryId = $category->id;

            $income = Income::create([
                'user_id' => $userId,
                'tanggal' => $request->input('tanggal'),
                'kategori' => $request->input('kategori'),
                'deskripsi' => $request->input('deskripsi'),
                'jumlah' => $request->input('jumlah'),
                'category_id' => $categoryId,
            ]);
            return response()->json(['message' => 'income created successfully!'], 201);
        } catch (\Exception $e) {
            Log::error('Error creating income: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create income'], 500);
        }
    }

    public function show($id)
    {
        $income = Income::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return response()->json($income, 200);
    }

    public function update(Request $request, $id)
    {
        $income = Income::find($id);

        if (!$income) {
            return response()->json(['message' => 'Income not found'], 404);
        }

        $income->tanggal = $request->input('tanggal');
        $income->kategori = $request->input('kategori');
        $income->deskripsi = $request->input('deskripsi');
        $income->jumlah = $request->input('jumlah');

        $income->save();

        return response()->json(['message' => 'Income updated successfully', 'income' => $income], 200);
    }

    public function destroy($id)
    {
        $income = Income::find($id);

        if (!$income) {
            return response()->json(['message' => 'Income not found'], 404);
        }

        $income->delete();

        return response()->json(['message' => 'Income deleted successfully'], 200);
    }
}
