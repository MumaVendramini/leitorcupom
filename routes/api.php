<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CupomFiscalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rotas de notas movidas para web.php para usar sessão corretamente.

// Rota de debug opcional para inspecionar autenticação (NÃO AUTENTICADA)
Route::get('/auth-info', function (Request $request) {
    return response()->json([
        'auth_check' => auth()->check(),
        'guard_web_user' => auth('web')->user(),
        'session_cookie_present' => $request->hasCookie(config('session.cookie')),
    ]);
});
