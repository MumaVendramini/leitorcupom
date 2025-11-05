<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotaFiscalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API de Notas Fiscais (requer autenticação)
Route::middleware(['auth:sanctum'])->prefix('notas')->group(function () {
    Route::get('/', [NotaFiscalController::class, 'index']); // Listar notas
    Route::post('/', [NotaFiscalController::class, 'store']); // Registrar nova nota
    Route::get('/{id}', [NotaFiscalController::class, 'show']); // Ver detalhes
    Route::delete('/{id}', [NotaFiscalController::class, 'destroy']); // Deletar nota
});
