<?php

namespace App\Http\Controllers;

use App\Models\Facilitador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacilitadorController extends Controller
{
    // Dashboard do Facilitador
    public function dashboard()
    {
        $facilitador = Auth::guard('facilitador')->user();
        
        // Total de usuários indicados
        $totalUsuarios = $facilitador->usuarios()->count();
        
        // Total de notas dos usuários indicados
        $totalNotas = $facilitador->notasFiscais()->count();
        
        // Valor total das notas
        $valorTotal = $facilitador->notasFiscais()->sum('valor');
        
        // Usuários com suas contagens de notas
        $usuarios = $facilitador->usuarios()
            ->withCount('notasFiscais')
            ->with(['notasFiscais' => function($query) {
                $query->latest()->limit(5);
            }])
            ->get();

        return view('facilitador.dashboard', compact('facilitador', 'totalUsuarios', 'totalNotas', 'valorTotal', 'usuarios'));
    }

    // Relatório detalhado
    public function relatorio(Request $request)
    {
        $facilitador = Auth::guard('facilitador')->user();
        
        $query = $facilitador->notasFiscais()->with('usuario');
        
        // Filtros opcionais
        if ($request->mes) {
            $query->where('mes', $request->mes);
        }
        if ($request->ano) {
            $query->where('ano', $request->ano);
        }
        
        $notas = $query->latest()->paginate(20);
        
        return view('facilitador.relatorio', compact('notas', 'facilitador'));
    }

    // Listar facilitadores (apenas admin)
    public function index()
    {
        $facilitadores = Facilitador::withCount(['usuarios', 'notasFiscais'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.facilitadores.index', compact('facilitadores'));
    }

    // Ver detalhes de um facilitador (admin)
    public function show($id)
    {
        $facilitador = Facilitador::with(['usuarios.notasFiscais'])->findOrFail($id);
        
        return view('admin.facilitadores.show', compact('facilitador'));
    }
}
