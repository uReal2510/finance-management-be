<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        return response()->json($accounts, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'balance' => 'required|numeric',
        ]);

        $account = Account::create($request->all());
        return response()->json($account, 201);
    }

    public function show($id)
    {
        $account = Account::findOrFail($id);
        return response()->json($account, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string',
            'balance' => 'sometimes|required|numeric',
        ]);

        $account = Account::findOrFail($id);
        $account->update($request->all());
        return response()->json($account, 200);
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();
        return response()->json(null, 204);
    }
}
