<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Facilitador;
use App\Models\Usuario;
use App\Models\CupomFiscal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    /**
     * Seed de demonstração com dados de teste
     */
    public function run()
    {
        // Criar Facilitadores
        $facilitador1 = Facilitador::firstOrCreate(
            ['email' => 'joao@facilitador.com'],
            [
                'nome' => 'João Silva',
                'password' => Hash::make('password'),
                'codigo_indicacao' => 'JOAO2025',
            ]
        );

        $facilitador2 = Facilitador::firstOrCreate(
            ['email' => 'maria@facilitador.com'],
            [
                'nome' => 'Maria Santos',
                'password' => Hash::make('password'),
                'codigo_indicacao' => 'MARIA2025',
            ]
        );

        echo "✓ Facilitadores criados\n";
        echo "  - joao@facilitador.com (senha: password) - Código: JOAO2025\n";
        echo "  - maria@facilitador.com (senha: password) - Código: MARIA2025\n\n";

        // Criar Usuários para o Facilitador 1
        $usuario1 = Usuario::firstOrCreate(
            ['email' => 'pedro@usuario.com'],
            [
                'nome' => 'Pedro Oliveira',
                'password' => Hash::make('password'),
                'facilitador_id' => $facilitador1->id,
            ]
        );

        $usuario2 = Usuario::firstOrCreate(
            ['email' => 'ana@usuario.com'],
            [
                'nome' => 'Ana Costa',
                'password' => Hash::make('password'),
                'facilitador_id' => $facilitador1->id,
            ]
        );

        // Criar Usuário para o Facilitador 2
        $usuario3 = Usuario::firstOrCreate(
            ['email' => 'carlos@usuario.com'],
            [
                'nome' => 'Carlos Mendes',
                'password' => Hash::make('password'),
                'facilitador_id' => $facilitador2->id,
            ]
        );

        echo "✓ Usuários criados\n";
        echo "  - pedro@usuario.com (senha: password)\n";
        echo "  - ana@usuario.com (senha: password)\n";
        echo "  - carlos@usuario.com (senha: password)\n\n";

        // Criar Cupons Fiscais de exemplo (antes eram Notas)
        $cuponsData = [
            [
                'usuario_id' => $usuario1->id,
                'chave_acesso' => '35250212345678000123550010000001231234567890',
                'cnpj' => '12345678000123',
                'data_emissao' => now()->subDays(5),
                'valor' => 150.00,
                'uf' => 'SP',
                'ano' => 2025,
                'mes' => 1,
                'modelo' => '65',
                'numero_nf' => '123',
                'serie' => '1',
                'codigo_num' => null,
                'dv' => null,
                'sat' => null,
                'qr_conteudo' => null,
            ],
            [
                'usuario_id' => $usuario1->id,
                'chave_acesso' => '35250212345678000123550010000001241234567891',
                'cnpj' => '98765432000198',
                'data_emissao' => now()->subDays(3),
                'valor' => 89.90,
                'uf' => 'SP',
                'ano' => 2025,
                'mes' => 1,
                'modelo' => '65',
                'numero_nf' => '124',
                'serie' => '1',
                'codigo_num' => null,
                'dv' => null,
                'sat' => null,
                'qr_conteudo' => null,
            ],
            [
                'usuario_id' => $usuario2->id,
                'chave_acesso' => '35250212345678000123550010000001251234567892',
                'cnpj' => '11222333000144',
                'data_emissao' => now()->subDays(2),
                'valor' => 250.50,
                'uf' => 'RJ',
                'ano' => 2025,
                'mes' => 1,
                'modelo' => '65',
                'numero_nf' => '125',
                'serie' => '2',
                'codigo_num' => null,
                'dv' => null,
                'sat' => null,
                'qr_conteudo' => null,
            ],
            [
                'usuario_id' => $usuario3->id,
                'chave_acesso' => '35250212345678000123550010000001261234567893',
                'cnpj' => '55666777000155',
                'data_emissao' => now()->subDays(1),
                'valor' => 320.00,
                'uf' => 'MG',
                'ano' => 2025,
                'mes' => 1,
                'modelo' => '65',
                'numero_nf' => '126',
                'serie' => '1',
                'codigo_num' => null,
                'dv' => null,
                'sat' => null,
                'qr_conteudo' => null,
            ],
        ];

        foreach ($cuponsData as $cupomData) {
            CupomFiscal::firstOrCreate(
                ['chave_acesso' => $cupomData['chave_acesso']],
                $cupomData
            );
        }

        echo "✓ Cupons fiscais de exemplo criados\n\n";
        echo "===========================================\n";
        echo "Dados de teste criados com sucesso!\n";
        echo "===========================================\n";
    }
}
