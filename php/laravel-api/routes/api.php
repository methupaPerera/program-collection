<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\CustomerController;
use App\Http\Controllers\Api\v1\InvoiceController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(["prefix" => "v1"], function () {
    Route::apiResource("customers", CustomerController::class);
    Route::apiResource("invoices", InvoiceController::class);
    Route::post("invoices/bulk", [InvoiceController::class, "bulk_store"]);
});
