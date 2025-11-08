<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Facilitador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Login de Usuário
    public function loginUsuario(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario && Hash::check($request->password, $usuario->password)) {
            Auth::guard('web')->login($usuario);
            $request->session()->regenerate();
            
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    // Login de Facilitador
    public function loginFacilitador(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $facilitador = Facilitador::where('email', $request->email)->first();

        if ($facilitador && Hash::check($request->password, $facilitador->password)) {
            Auth::guard('facilitador')->login($facilitador);
            $request->session()->regenerate();
            
            return redirect()->intended('/facilitador/dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    // Cadastro de Usuário com código do facilitador
    public function registerUsuario(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios',
            'password' => 'required|min:6|confirmed',
            'codigo_facilitador' => 'required|exists:facilitadors,codigo_indicacao',
        ]);

        $facilitador = Facilitador::where('codigo_indicacao', $request->codigo_facilitador)->first();

        $usuario = Usuario::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'facilitador_id' => $facilitador->id,
        ]);

        Auth::guard('web')->login($usuario);

        return redirect('/dashboard');
    }

    // Cadastro de Facilitador (apenas admin pode fazer via seed ou interface admin)
    public function registerFacilitador(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:facilitadors',
            'password' => 'required|min:6|confirmed',
        ]);

        $facilitador = Facilitador::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'codigo_indicacao' => strtoupper(Str::random(8)), // Gera código único
        ]);

        return redirect()->back()->with('success', 'Facilitador criado com sucesso! Código: ' . $facilitador->codigo_indicacao);
    }

    // Login de Admin (User model)
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::guard('admin')->user();
            
            // Verificar se tem permissão de admin
            if ($user->role === 'admin' || $user->role === 'super_admin') {
                return redirect()->intended('/admin/dashboard');
            }
            
            // Se não for admin, faz logout
            Auth::guard('admin')->logout();
            return back()->withErrors([
                'email' => 'Você não tem permissão de administrador.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        // Logout seguro para múltiplos guards
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
        if (Auth::guard('facilitador')->check()) {
            Auth::guard('facilitador')->logout();
        }
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
