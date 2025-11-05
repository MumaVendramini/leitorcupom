<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FacilitadorController;
use App\Http\Controllers\NotaFiscalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página inicial
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rotas de autenticação
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login/usuario', [AuthController::class, 'loginUsuario'])->name('login.usuario');
Route::post('/login/facilitador', [AuthController::class, 'loginFacilitador'])->name('login.facilitador');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register/usuario', [AuthController::class, 'registerUsuario'])->name('register.usuario');
Route::post('/register/facilitador', [AuthController::class, 'registerFacilitador'])->name('register.facilitador');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas do Usuário (autenticadas)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UsuarioController::class, 'dashboard'])->name('usuario.dashboard');
    Route::get('/minhas-notas', [UsuarioController::class, 'minhasNotas'])->name('usuario.notas');
    Route::get('/scan-qrcode', [UsuarioController::class, 'scanQRCode'])->name('usuario.scan');
});

// Rotas do Facilitador (autenticadas)
Route::middleware(['auth:facilitador'])->prefix('facilitador')->group(function () {
    Route::get('/dashboard', [FacilitadorController::class, 'dashboard'])->name('facilitador.dashboard');
    Route::get('/relatorio', [FacilitadorController::class, 'relatorio'])->name('facilitador.relatorio');
});

// Rotas Admin (TODO: adicionar middleware admin)
Route::prefix('admin')->group(function () {
    Route::get('/facilitadores', [FacilitadorController::class, 'index'])->name('admin.facilitadores.index');
    Route::get('/facilitadores/{id}', [FacilitadorController::class, 'show'])->name('admin.facilitadores.show');
});
