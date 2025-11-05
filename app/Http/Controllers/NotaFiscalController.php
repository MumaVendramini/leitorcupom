<?php

namespace App\Http\Controllers;

use App\Models\NotaFiscal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class NotaFiscalController extends Controller
{
    // Registrar nota fiscal a partir do QR Code
    public function store(Request $request)
    {
        $request->validate([
            'chave_acesso' => 'required|string|size:44|unique:nota_fiscals,chave_acesso',
        ]);

        $usuario = Auth::user();
        $chaveAcesso = $request->chave_acesso;

        // Extrair informações da chave de acesso (44 caracteres)
        // Estrutura da chave: UF(2) + AAMM(4) + CNPJ(14) + Modelo(2) + Serie(3) + NNF(9) + Tipo(1) + Código(8) + DV(1)
        
        try {
            $uf = substr($chaveAcesso, 0, 2);
            $aamm = substr($chaveAcesso, 2, 4);
            $cnpj = substr($chaveAcesso, 6, 14);
            $modelo = substr($chaveAcesso, 20, 2);
            $serie = substr($chaveAcesso, 22, 3);
            $numeroNf = substr($chaveAcesso, 25, 9);

            $ano = 2000 + (int)substr($aamm, 0, 2);
            $mes = (int)substr($aamm, 2, 2);

            // Aqui você pode fazer uma consulta à SEFAZ para buscar mais dados da nota
            // Por enquanto, vamos armazenar com dados básicos
            // TODO: Implementar integração com API da SEFAZ

            $notaFiscal = NotaFiscal::create([
                'usuario_id' => $usuario->id,
                'chave_acesso' => $chaveAcesso,
                'cnpj' => $cnpj,
                'data_emissao' => now(), // Idealmente vem da consulta SEFAZ
                'valor' => $request->valor ?? 0, // Temporário - deve vir da SEFAZ
                'cidade' => $request->cidade ?? 'N/A', // Temporário
                'ano' => $ano,
                'mes' => $mes,
                'modelo' => $modelo,
                'numero_nf' => ltrim($numeroNf, '0'),
                'serie' => ltrim($serie, '0'),
                'sat' => $request->sat ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Nota fiscal registrada com sucesso!',
                'nota' => $notaFiscal,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar a chave de acesso: ' . $e->getMessage(),
            ], 400);
        }
    }

    // Consultar nota na SEFAZ (implementação futura)
    private function consultarNotaSefaz($chaveAcesso)
    {
        // TODO: Implementar consulta real à SEFAZ
        // Exemplo: https://www.nfe.fazenda.gov.br/portal/consultaRecaptcha.aspx
        
        return null;
    }

    // API para listar notas (usado pelo front)
    public function index(Request $request)
    {
        $usuario = Auth::user();
        
        $notas = $usuario->notasFiscais()
            ->latest()
            ->paginate(20);

        return response()->json($notas);
    }

    // Ver detalhes de uma nota
    public function show($id)
    {
        $usuario = Auth::user();
        
        $nota = NotaFiscal::where('id', $id)
            ->where('usuario_id', $usuario->id)
            ->firstOrFail();

        return response()->json($nota);
    }

    // Deletar uma nota (caso necessário)
    public function destroy($id)
    {
        $usuario = Auth::user();
        
        $nota = NotaFiscal::where('id', $id)
            ->where('usuario_id', $usuario->id)
            ->firstOrFail();

        $nota->delete();

        return response()->json([
            'success' => true,
            'message' => 'Nota fiscal removida com sucesso!',
        ]);
    }
}
