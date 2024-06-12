<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:api')->get('/profile', [AuthController::class, 'edit'])->name('profile.edit');
Route::middleware('auth:api')->put('/profile', [AuthController::class, 'update'])->name('profile.update');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', function (Request $request) {
        return response()->json($request->user());
    });
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/profile', [AuthController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AuthController::class, 'update'])->name('profile.update');
    Route::get('/expenses', [ExpenseController::class, 'index']);
    Route::get('/incomes', [IncomeController::class, 'index']);
    // Route::get('/categories', [CategoryController::class, 'index']);

    Route::post('/expenses', [ExpenseController::class, 'store']);
    Route::put('/expenses/{id}', [ExpenseController::class, 'update']);
    Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy']);

    Route::post('/incomes', [IncomeController::class, 'store']);
    Route::put('/incomes/{id}', [IncomeController::class, 'update']);
    Route::delete('/incomes/{id}', [IncomeController::class, 'destroy']);

    Route::apiResource('transactions', TransactionController::class);
    Route::apiResource('accounts', AccountController::class);
    Route::apiResource('categories', CategoryController::class);
});



// Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login']);

// // Route::middleware('auth:sanctum')->group(function () {
// //     Route::post('/logout', [AuthController::class, 'logout']);
// // });

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('user', function (Request $request) {
//         return response()->json($request->user());
//         // return $request->user();
//     });
// });

// Route::apiResource('transactions', TransactionController::class);
// Route::apiResource('accounts', AccountController::class);
// Route::apiResource('categories', CategoryController::class);
// Route::middleware('auth:api')->get('/profile', [AuthController::class, 'profile']);