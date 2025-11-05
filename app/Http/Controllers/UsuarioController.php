<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    // Dashboard do Usuário
    public function dashboard()
    {
        $usuario = Auth::user();
        
        // Total de notas cadastradas
        $totalNotas = $usuario->notasFiscais()->count();
        
        // Valor total
        $valorTotal = $usuario->notasFiscais()->sum('valor');
        
        // Últimas notas
        $notasRecentes = $usuario->notasFiscais()
            ->latest()
            ->limit(10)
            ->get();

        return view('usuario.dashboard', compact('usuario', 'totalNotas', 'valorTotal', 'notasRecentes'));
    }

    // Listar todas as notas do usuário
    public function minhasNotas(Request $request)
    {
        $usuario = Auth::user();
        
        $query = $usuario->notasFiscais();
        
        // Filtros opcionais
        if ($request->mes) {
            $query->where('mes', $request->mes);
        }
        if ($request->ano) {
            $query->where('ano', $request->ano);
        }
        
        $notas = $query->latest()->paginate(15);
        
        return view('usuario.notas', compact('notas', 'usuario'));
    }

    // Página de leitura de QR Code
    public function scanQRCode()
    {
        return view('usuario.scan-qrcode');
    }
}
