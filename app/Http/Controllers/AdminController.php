<?php

namespace App\Http\Controllers;

use App\Models\Facilitador;
use App\Models\CupomFiscal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function dashboard()
    {
        $totalFacilitadores = Facilitador::count();
        $totalCupons = CupomFiscal::count();
        $cupomsMês = CupomFiscal::whereMonth('created_at', now()->month)
                               ->whereYear('created_at', now()->year)
                               ->count();
        $valorTotal = CupomFiscal::sum('valor');
        
        // Últimos cupons por facilitador
        $cupomsPorFacilitador = Facilitador::with('usuarios')->get()->take(5)->map(function($f) {
            return [
                'facilitador' => $f->nome,
                'cupons' => $f->usuarios->sum(function($u) {
                    return $u->notasFiscais()->count();
                }),
                'usuarios' => $f->usuarios->count(),
                'valor' => $f->usuarios->sum(function($u) {
                    return $u->notasFiscais()->sum('valor');
                }),
            ];
        })->toArray();

        return view('admin.dashboard', compact(
            'totalFacilitadores',
            'totalCupons',
            'cupomsMês',
            'valorTotal',
            'cupomsPorFacilitador'
        ));
    }

    /**
     * Listar facilitadores (index)
     */
    public function index()
    {
        $facilitadores = Facilitador::withCount('usuarios')->paginate(15);
        return view('admin.facilitadores.index', compact('facilitadores'));
    }

    /**
     * Listar facilitadores
     */
    public function facilitadores()
    {
        return $this->index();
    }

    /**
     * Criar novo facilitador
     */
    public function criarFacilitador()
    {
        return view('admin.facilitadores.create');
    }

    /**
     * Salvar novo facilitador
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:facilitadors',
            'password' => 'required|string|min:6',
            'telefone' => 'nullable|string|min:10|max:20',
            'cpf' => 'required|string|size:11|unique:facilitadors',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|size:2',
        ], [
            'nome.required' => 'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'Digite um email válido',
            'email.unique' => 'Este email já está cadastrado',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres',
            'telefone.min' => 'O telefone deve ter no mínimo 10 dígitos',
            'cpf.required' => 'O CPF é obrigatório',
            'cpf.size' => 'O CPF deve ter 11 dígitos',
            'cpf.unique' => 'Este CPF já está cadastrado',
            'cidade.required' => 'A cidade é obrigatória',
            'estado.required' => 'O estado é obrigatório',
        ]);

        // Remove formatação do telefone e CPF
        $data = $request->all();
        if (isset($data['telefone'])) {
            $data['telefone'] = preg_replace('/[^0-9]/', '', $data['telefone']);
            // Valida telefone após remoção de formatação
            if (strlen($data['telefone']) > 0 && strlen($data['telefone']) < 10) {
                return back()->withErrors(['telefone' => 'O telefone deve ter no mínimo 10 dígitos'])->withInput();
            }
        }
        if (isset($data['cpf'])) {
            $data['cpf'] = preg_replace('/[^0-9]/', '', $data['cpf']);
            // Valida CPF após remoção de formatação
            if (strlen($data['cpf']) !== 11) {
                return back()->withErrors(['cpf' => 'O CPF deve ter 11 dígitos'])->withInput();
            }
            // Valida CPF (algoritmo)
            if (!$this->validarCPF($data['cpf'])) {
                return back()->withErrors(['cpf' => 'CPF inválido'])->withInput();
            }
        }
        
        // Hash da senha
        $data['password'] = bcrypt($data['password']);
        
        // Gera código de indicação único
        do {
            $data['codigo_indicacao'] = strtoupper(Str::random(8));
        } while (Facilitador::where('codigo_indicacao', $data['codigo_indicacao'])->exists());

        Facilitador::create($data);

        return redirect()->route('admin.facilitadores.index')->with('success', 'Facilitador criado com sucesso!');
    }

    /**
     * Salvar novo facilitador (compat)
     */
    public function salvarFacilitador(Request $request)
    {
        return $this->store($request);
    }

    /**
     * Editar facilitador
     */
    public function edit(Facilitador $facilitador)
    {
        return view('admin.facilitadores.edit', compact('facilitador'));
    }

    /**
     * Atualizar facilitador
     */
    public function update(Request $request, Facilitador $facilitador)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:facilitadors,email,' . $facilitador->id,
            'telefone' => 'nullable|string|max:20',
            'cpf' => 'required|string|unique:facilitadors,cpf,' . $facilitador->id,
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|size:2',
        ]);

        $facilitador->update($request->all());

        return redirect()->route('admin.facilitadores.index')->with('success', 'Facilitador atualizado com sucesso!');
    }

    /**
     * Deletar facilitador
     */
    public function destroy(Facilitador $facilitador)
    {
        $facilitador->delete();

        return redirect()->route('admin.facilitadores.index')->with('success', 'Facilitador deletado com sucesso!');
    }

    /**
     * Gerar código de indicação
     */
    public function gerarCodigo(Facilitador $facilitador)
    {
        $codigo = strtoupper(Str::random(8));
        
        $facilitador->update(['codigo_indicacao' => $codigo]);

        return back()->with('success', "Código gerado: {$codigo}");
    }

    /**
     * Relatório de cupons por facilitador
     */
    public function relatorioFacilitador()
    {
        $facilitadoresData = Facilitador::with('usuarios')->get()->map(function($f) {
            return [
                'nome' => $f->nome,
                'email' => $f->email,
                'total_usuarios' => $f->usuarios->count(),
                'total_cupons' => $f->usuarios->sum(function($u) {
                    return $u->notasFiscais()->count();
                }),
                'valor_total' => $f->usuarios->sum(function($u) {
                    return $u->notasFiscais()->sum('valor');
                }),
            ];
        });

        // Paginar manualmente
        $page = request()->get('page', 1);
        $perPage = 20;
        $facilitadores = new \Illuminate\Pagination\Paginator(
            $facilitadoresData->forPage($page, $perPage)->values(),
            $perPage,
            $page,
            [
                'path' => route('admin.relatorio-facilitador'),
                'query' => request()->query(),
            ]
        );

        return view('admin.relatorios.facilitador', compact('facilitadores'));
    }

    /**
     * Relatório mensal de cupons
     */
    public function relatorioMensal(Request $request)
    {
        $mes = $request->get('mes', now()->month);
        $ano = $request->get('ano', now()->year);

        $cupons = CupomFiscal::whereMonth('created_at', $mes)
                            ->whereYear('created_at', $ano)
                            ->with(['facilitador', 'usuario'])
                            ->latest()
                            ->paginate(20);

        return view('admin.relatorios.mensal', compact('cupons', 'mes', 'ano'));
    }

    /**
     * Dashboard Super Admin (Desenvolvedor)
     */
    public function superAdminDashboard()
    {
        return view('admin.super-admin.dashboard');
    }

    /**
     * Validar CPF
     */
    private function validarCPF($cpf)
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        
        // Verifica se tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }
        
        // Verifica se todos os dígitos são iguais
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        
        // Valida primeiro dígito verificador
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += intval($cpf[$i]) * (10 - $i);
        }
        $resto = $soma % 11;
        $digito1 = ($resto < 2) ? 0 : (11 - $resto);
        
        if (intval($cpf[9]) !== $digito1) {
            return false;
        }
        
        // Valida segundo dígito verificador
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += intval($cpf[$i]) * (11 - $i);
        }
        $resto = $soma % 11;
        $digito2 = ($resto < 2) ? 0 : (11 - $resto);
        
        return intval($cpf[10]) === $digito2;
    }
}
