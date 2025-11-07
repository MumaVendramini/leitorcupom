<?php

namespace Tests\Feature;

use App\Models\Facilitador;
use App\Models\NotaFiscal;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_autenticado_pode_acessar_dashboard()
    {
        $facilitador = Facilitador::create([
            'nome' => 'Facilitador Teste',
            'email' => 'facilitador@test.com',
            'password' => Hash::make('password'),
            'codigo_indicacao' => 'TEST001',
        ]);

        $usuario = Usuario::create([
            'nome' => 'Usuario Teste',
            'email' => 'usuario@test.com',
            'password' => Hash::make('password'),
            'facilitador_id' => $facilitador->id,
        ]);

        $this->actingAs($usuario, 'web');

        $response = $this->get('/dashboard');

        $response->assertStatus(200)
            ->assertSee('Usuario Teste');
    }

    /** @test */
    public function usuario_nao_autenticado_nao_pode_acessar_dashboard()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function facilitador_autenticado_pode_acessar_seu_dashboard()
    {
        $facilitador = Facilitador::create([
            'nome' => 'Facilitador Teste',
            'email' => 'facilitador@test.com',
            'password' => Hash::make('password'),
            'codigo_indicacao' => 'TEST001',
        ]);

        $this->actingAs($facilitador, 'facilitador');

        $response = $this->get('/facilitador/dashboard');

        $response->assertStatus(200)
            ->assertSee('TEST001')
            ->assertSee('Facilitador Teste');
    }

    /** @test */
    public function facilitador_dashboard_mostra_usuarios_indicados()
    {
        $facilitador = Facilitador::create([
            'nome' => 'Facilitador Teste',
            'email' => 'facilitador@test.com',
            'password' => Hash::make('password'),
            'codigo_indicacao' => 'TEST001',
        ]);

        $usuario1 = Usuario::create([
            'nome' => 'Usuario 1',
            'email' => 'usuario1@test.com',
            'password' => Hash::make('password'),
            'facilitador_id' => $facilitador->id,
        ]);

        $usuario2 = Usuario::create([
            'nome' => 'Usuario 2',
            'email' => 'usuario2@test.com',
            'password' => Hash::make('password'),
            'facilitador_id' => $facilitador->id,
        ]);

        NotaFiscal::create([
            'usuario_id' => $usuario1->id,
            'chave_acesso' => '35250212345678000123550010000001231234567890',
            'cnpj' => '12345678000123',
            'data_emissao' => now(),
            'valor' => 150.00,
            'cidade' => 'São Paulo',
            'ano' => 2025,
            'mes' => 1,
            'modelo' => '55',
            'numero_nf' => '123',
        ]);

        $this->actingAs($facilitador, 'facilitador');

        $response = $this->get('/facilitador/dashboard');

        $response->assertStatus(200)
            ->assertSee('Usuario 1')
            ->assertSee('Usuario 2');
    }

    /** @test */
    public function usuario_pode_acessar_pagina_scan_qrcode()
    {
        $facilitador = Facilitador::create([
            'nome' => 'Facilitador Teste',
            'email' => 'facilitador@test.com',
            'password' => Hash::make('password'),
            'codigo_indicacao' => 'TEST001',
        ]);

        $usuario = Usuario::create([
            'nome' => 'Usuario Teste',
            'email' => 'usuario@test.com',
            'password' => Hash::make('password'),
            'facilitador_id' => $facilitador->id,
        ]);

        $this->actingAs($usuario, 'web');

        $response = $this->get('/scan-qrcode');

        $response->assertStatus(200);
    }
}
