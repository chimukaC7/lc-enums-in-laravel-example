<?php

use App\Enums\Status;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Enum;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome', [
        'orders' => Order::all(),
    ]);
});

Route::get('/create', function (Request $request) {
    $request->validate([
        'total' => 'required',
        // 'status' => 'required|integer',
        'status' => [new Enum(Status::class)],
    ]);

    Order::create([
        'total' => $request->total,
        'status' => $request->status,
    ]);

    return 'Created Order!';
});
