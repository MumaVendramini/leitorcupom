<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FacilitadorController;
use App\Http\Controllers\CupomFiscalController;
use App\Http\Controllers\AdminController;

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

// Login de Admin
Route::get('/admin/login', function () {
    return view('auth.admin-login');
})->name('admin.login');

Route::post('/admin/login', [AuthController::class, 'loginAdmin'])->name('admin.login.post');

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
    
    // Login direto como Super Admin (para testes)
    Route::get('/debug/login-super-admin', function () {
        $user = \App\Models\User::where('email','super@admin.com')->first();
        if (!$user) {
            return 'Super Admin não encontrado. Execute: php artisan db:seed --class=SuperAdminSeeder';
        }
        \Illuminate\Support\Facades\Auth::guard('admin')->login($user);
        request()->session()->regenerate();
        return redirect('/admin/dashboard');
    });
    
    // Login direto como Admin (para testes)
    Route::get('/debug/login-admin', function () {
        $user = \App\Models\User::where('email','admin@admin.com')->first();
        if (!$user) {
            return 'Admin não encontrado. Execute: php artisan db:seed --class=SuperAdminSeeder';
        }
        \Illuminate\Support\Facades\Auth::guard('admin')->login($user);
        request()->session()->regenerate();
        return redirect('/admin/dashboard');
    });
}

// Rotas do Facilitador (autenticadas)
Route::middleware(['auth:facilitador'])->prefix('facilitador')->group(function () {
    Route::get('/dashboard', [FacilitadorController::class, 'dashboard'])->name('facilitador.dashboard');
    Route::get('/relatorio', [FacilitadorController::class, 'relatorio'])->name('facilitador.relatorio');
});

// Rotas Admin (Gerenciamento completo - roles admin/super_admin)
Route::middleware(['auth:admin', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('index');
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Facilitadores
    Route::get('/facilitadores', [AdminController::class, 'index'])->name('facilitadores.index');
    Route::get('/facilitadores/criar', [AdminController::class, 'criarFacilitador'])->name('facilitadores.create');
    Route::post('/facilitadores', [AdminController::class, 'store'])->name('facilitadores.store');
    Route::get('/facilitadores/{facilitador}/editar', [AdminController::class, 'edit'])->name('facilitadores.edit');
    Route::put('/facilitadores/{facilitador}', [AdminController::class, 'update'])->name('facilitadores.update');
    Route::delete('/facilitadores/{facilitador}', [AdminController::class, 'destroy'])->name('facilitadores.destroy');
    Route::post('/facilitadores/{facilitador}/gerar-codigo', [AdminController::class, 'gerarCodigo'])->name('gerar-codigo');
    
    // Relatórios
    Route::get('/relatorios/facilitador', [AdminController::class, 'relatorioFacilitador'])->name('relatorio-facilitador');
    Route::get('/relatorios/mensal', [AdminController::class, 'relatorioMensal'])->name('relatorio-mensal');
    
    // Super Admin (Desenvolvedor)
    Route::middleware('super_admin')->group(function () {
        Route::get('/super', [AdminController::class, 'superAdminDashboard'])->name('super');
    });
});
