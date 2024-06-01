<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // Fetch all transactions
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json($transactions, 200);
    }

    // Store a new transaction
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'account_id' => 'required|exists:accounts,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        $transaction = Transaction::create($request->all());
        return response()->json($transaction, 201);
    }

    // Fetch a single transaction
    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->json($transaction, 200);
    }

    // Update a transaction
    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'sometimes|required|string',
            'amount' => 'sometimes|required|numeric',
            'date' => 'sometimes|required|date',
            'account_id' => 'sometimes|required|exists:accounts,id',
            'category_id' => 'sometimes|required|exists:categories,id',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());
        return response()->json($transaction, 200);
    }

    // Delete a transaction
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return response()->json(null, 204);
    }
}