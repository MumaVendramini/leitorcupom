<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FacilitadorController;
use App\Http\Controllers\CupomFiscalController;

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

// API de Cupons (usa sessão e guard web) -> mantém prefixo /api/notas igual ao front
Route::middleware(['auth'])->prefix('api/notas')->group(function () {
    Route::get('/', [CupomFiscalController::class, 'index']);
    Route::post('/', [CupomFiscalController::class, 'store']);
    Route::get('/{id}', [CupomFiscalController::class, 'show']);
    Route::delete('/{id}', [CupomFiscalController::class, 'destroy']);
});

// DEBUG (somente em ambiente local)
if (app()->environment('local')) {
    Route::get('/debug/usuarios', function () {
        return \App\Models\Usuario::select('id','nome','email')->get();
    });
    Route::get('/debug/login-pedro', function () {
        $u = \App\Models\Usuario::where('email','pedro@usuario.com')->first();
        if (!$u) {
            return 'Usuário pedro@usuario.com não existe';
        }
        \Illuminate\Support\Facades\Auth::guard('web')->login($u);
        request()->session()->regenerate();
        return redirect('/dashboard');
    });
}

// Rotas do Facilitador (autenticadas)
Route::middleware(['auth:facilitador'])->prefix('facilitador')->group(function () {
    Route::get('/dashboard', [FacilitadorController::class, 'dashboard'])->name('facilitador.dashboard');
    Route::get('/relatorio', [FacilitadorController::class, 'relatorio'])->name('facilitador.relatorio');
});

// Rotas Admin (proteção simples por enquanto - só facilitador ativo)
Route::middleware(['auth:facilitador'])->prefix('admin')->group(function () {
    Route::get('/facilitadores', [FacilitadorController::class, 'index'])->name('admin.facilitadores.index');
    Route::get('/facilitadores/{id}', [FacilitadorController::class, 'show'])->name('admin.facilitadores.show');
});
