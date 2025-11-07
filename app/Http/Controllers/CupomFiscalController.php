<?php

namespace App\Http\Controllers;

use App\Models\CupomFiscal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CupomFiscalController extends Controller
{
    // Registrar cupom fiscal a partir do QR Code
    public function store(Request $request)
    {
        $request->validate([
            'chave_acesso' => 'required|string|size:44|unique:cupons_fiscais,chave_acesso',
        ]);

        $usuario = Auth::user();
        $chaveAcesso = $request->chave_acesso;
        $qrConteudo = $request->input('qr_conteudo');

        // Extrair informações da chave de acesso (44 caracteres)
        // Estrutura da chave: UF(2) + AAMM(4) + CNPJ(14) + Modelo(2) + Serie(3) + NNF(9) + Tipo(1) + Código(8) + DV(1)
        
        try {
            // Parsing posições (com base na sua especificação)
            // Comum (65 e 59)
            $uf = substr($chaveAcesso, 0, 2);
            $ano2 = substr($chaveAcesso, 2, 2);
            $mes2 = substr($chaveAcesso, 4, 2);
            $cnpj = substr($chaveAcesso, 6, 14);
            $modelo = substr($chaveAcesso, 20, 2);
            $serieRaw = substr($chaveAcesso, 22, 3);
            $dv = substr($chaveAcesso, 43, 1);

            $ano = 2000 + (int)$ano2;
            $mes = (int)$mes2;

            // Campos que variam com o modelo
            $numeroNf = null;
            $codigoNum = null;
            $satCodigo = null;

            if ($modelo === '65') {
                // 65: numero 25-34, codigo numerico 35-43
                $numeroNf = ltrim(substr($chaveAcesso, 25, 9), '0');
                $codigoNum = substr($chaveAcesso, 34, 9);
            } elseif ($modelo === '59') {
                // 59: SAT 23-31, numero 32-37 (6), codigo numerico 41-43 (3)
                $satCodigo = ltrim(substr($chaveAcesso, 22, 9), '0');
                $numeroNf = ltrim(substr($chaveAcesso, 31, 6), '0');
                $codigoNum = substr($chaveAcesso, 40, 3);
            } else {
                // fallback: manter antiga (pode ajustar depois)
                $numeroNf = ltrim(substr($chaveAcesso, 25, 9), '0');
                $codigoNum = null;
            }

            // Aqui você pode fazer uma consulta à SEFAZ para buscar mais dados da nota
            // Por enquanto, vamos armazenar com dados básicos
            // TODO: Implementar integração com API da SEFAZ

            // Parsing adicional por modelo
            $valor = $request->valor ?? 0;
            $dataEmissao = $request->data_emissao ?? null;

            // Modelo 59 (CF-e SAT): frequentemente o QR contém campos separados por pipe com data/valor
            if ($modelo === '59' && $qrConteudo) {
                // Tenta extrair data (YYYYMMDDHHMMSS) e valor (n.nn)
                if (strpos($qrConteudo, '|') !== false) {
                    $parts = explode('|', $qrConteudo);
                    foreach ($parts as $p) {
                        $p = trim($p);
                        if (!$dataEmissao && preg_match('/^\d{14}$/', $p)) {
                            // Formato YYYYMMDDHHMMSS
                            $yyyy = substr($p, 0, 4);
                            $mm = substr($p, 4, 2);
                            $dd = substr($p, 6, 2);
                            $HH = substr($p, 8, 2);
                            $ii = substr($p, 10, 2);
                            $ss = substr($p, 12, 2);
                            $dataEmissao = "$yyyy-$mm-$dd $HH:$ii:$ss";
                        }
                        if (($valor === 0 || $valor === '0' || $valor === null) && preg_match('/^\d+(?:[\.,]\d{2})$/', $p)) {
                            $valor = (float) str_replace(',', '.', $p);
                        }
                    }
                }
            }

            // Modelo 65 (NFC-e): frequentemente só temos a chave/URL; guardar conteúdo bruto para posterior validação
            // Em ambos os casos, manter qr_conteudo salvo

            $cupomFiscal = CupomFiscal::create([
                'usuario_id' => $usuario->id,
                'chave_acesso' => $chaveAcesso,
                'cnpj' => $cnpj,
                'data_emissao' => $dataEmissao ? $dataEmissao : now(), // Idealmente vem da SEFAZ
                'valor' => $valor, // Temporário - deve vir da SEFAZ/parse
                'uf' => $uf,
                'ano' => $ano,
                'mes' => $mes,
                'modelo' => $modelo,
                'numero_nf' => $numeroNf,
                'codigo_num' => $codigoNum,
                'serie' => ltrim($serieRaw, '0'),
                'sat' => $satCodigo ?? ($request->sat ?? null),
                'dv' => $dv,
                'qr_conteudo' => $qrConteudo,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cupom fiscal registrado com sucesso!',
                'cupom' => $cupomFiscal,
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

    // API para listar cupons (usado pelo front)
    public function index(Request $request)
    {
        $usuario = Auth::user();
        
        $cupons = $usuario->cuponsFiscais()
            ->latest()
            ->paginate(20);

        return response()->json($cupons);
    }

    // Ver detalhes de um cupom
    public function show($id)
    {
        $usuario = Auth::user();
        
        $cupom = CupomFiscal::where('id', $id)
            ->where('usuario_id', $usuario->id)
            ->firstOrFail();

        return response()->json($cupom);
    }

    // Deletar um cupom (caso necessário)
    public function destroy($id)
    {
        $usuario = Auth::user();
        
        $cupom = CupomFiscal::where('id', $id)
            ->where('usuario_id', $usuario->id)
            ->firstOrFail();

        $cupom->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cupom fiscal removido com sucesso!',
        ]);
    }
}
