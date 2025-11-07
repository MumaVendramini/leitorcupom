<?php

namespace Tests\Feature;

use App\Models\Facilitador;
use App\Models\NotaFiscal;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class NotaFiscalTest extends TestCase
{
    use RefreshDatabase;

    private $usuario;
    private $facilitador;

    protected function setUp(): void
    {
        parent::setUp();

        $this->facilitador = Facilitador::create([
            'nome' => 'Facilitador Teste',
            'email' => 'facilitador@test.com',
            'password' => Hash::make('password'),
            'codigo_indicacao' => 'TEST001',
        ]);

        $this->usuario = Usuario::create([
            'nome' => 'Usuario Teste',
            'email' => 'usuario@test.com',
            'password' => Hash::make('password'),
            'facilitador_id' => $this->facilitador->id,
        ]);
    }

    /** @test */
    public function usuario_pode_registrar_nota_fiscal_com_chave_valida()
    {
        $this->actingAs($this->usuario, 'web');

        $chaveAcesso = '35250212345678000123550010000001231234567890';

        $response = $this->postJson('/api/notas', [
            'chave_acesso' => $chaveAcesso,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Nota fiscal registrada com sucesso!',
            ]);

        $this->assertDatabaseHas('nota_fiscals', [
            'chave_acesso' => $chaveAcesso,
            'usuario_id' => $this->usuario->id,
        ]);
    }

    /** @test */
    public function nao_pode_registrar_nota_com_chave_duplicada()
    {
        $this->actingAs($this->usuario, 'web');

        $chaveAcesso = '35250212345678000123550010000001231234567890';

        // Primeira inserção
        NotaFiscal::create([
            'usuario_id' => $this->usuario->id,
            'chave_acesso' => $chaveAcesso,
            'cnpj' => '12345678000123',
            'data_emissao' => now(),
            'valor' => 100,
            'cidade' => 'São Paulo',
            'ano' => 2025,
            'mes' => 1,
            'modelo' => '55',
            'numero_nf' => '123',
        ]);

        // Tentativa duplicada
        $response = $this->postJson('/api/notas', [
            'chave_acesso' => $chaveAcesso,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['chave_acesso']);
    }

    /** @test */
    public function nao_pode_registrar_nota_com_chave_invalida()
    {
        $this->actingAs($this->usuario, 'web');

        // Chave com tamanho incorreto
        $response = $this->postJson('/api/notas', [
            'chave_acesso' => '123456',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['chave_acesso']);
    }

    /** @test */
    public function usuario_pode_listar_suas_notas()
    {
        $this->actingAs($this->usuario, 'web');

        NotaFiscal::create([
            'usuario_id' => $this->usuario->id,
            'chave_acesso' => '35250212345678000123550010000001231234567890',
            'cnpj' => '12345678000123',
            'data_emissao' => now(),
            'valor' => 100,
            'cidade' => 'São Paulo',
            'ano' => 2025,
            'mes' => 1,
            'modelo' => '55',
            'numero_nf' => '123',
        ]);

        $response = $this->getJson('/api/notas');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'chave_acesso', 'valor', 'usuario_id'],
                ],
            ]);
    }

    /** @test */
    public function usuario_nao_autenticado_nao_pode_registrar_nota()
    {
        $response = $this->postJson('/api/notas', [
            'chave_acesso' => '35250212345678000123550010000001231234567890',
        ]);

        $response->assertStatus(401);
    }

    /** @test */
    public function usuario_pode_deletar_sua_propria_nota()
    {
        $this->actingAs($this->usuario, 'web');

        $nota = NotaFiscal::create([
            'usuario_id' => $this->usuario->id,
            'chave_acesso' => '35250212345678000123550010000001231234567890',
            'cnpj' => '12345678000123',
            'data_emissao' => now(),
            'valor' => 100,
            'cidade' => 'São Paulo',
            'ano' => 2025,
            'mes' => 1,
            'modelo' => '55',
            'numero_nf' => '123',
        ]);

        $response = $this->deleteJson("/api/notas/{$nota->id}");

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('nota_fiscals', [
            'id' => $nota->id,
        ]);
    }
}
