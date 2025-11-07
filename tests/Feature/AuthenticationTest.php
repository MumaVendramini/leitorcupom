<?php

namespace Tests\Feature;

use App\Models\Facilitador;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_pode_fazer_login()
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

        $response = $this->post('/login/usuario', [
            'email' => 'usuario@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($usuario, 'web');
    }

    /** @test */
    public function facilitador_pode_fazer_login()
    {
        $facilitador = Facilitador::create([
            'nome' => 'Facilitador Teste',
            'email' => 'facilitador@test.com',
            'password' => Hash::make('password'),
            'codigo_indicacao' => 'TEST001',
        ]);

        $response = $this->post('/login/facilitador', [
            'email' => 'facilitador@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/facilitador/dashboard');
        $this->assertAuthenticatedAs($facilitador, 'facilitador');
    }

    /** @test */
    public function usuario_pode_se_registrar_com_codigo_valido()
    {
        $facilitador = Facilitador::create([
            'nome' => 'Facilitador Teste',
            'email' => 'facilitador@test.com',
            'password' => Hash::make('password'),
            'codigo_indicacao' => 'TEST001',
        ]);

        $response = $this->post('/register/usuario', [
            'nome' => 'Novo Usuario',
            'email' => 'novo@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'codigo_facilitador' => 'TEST001',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('usuarios', [
            'email' => 'novo@test.com',
            'facilitador_id' => $facilitador->id,
        ]);
    }

    /** @test */
    public function usuario_nao_pode_registrar_com_codigo_invalido()
    {
        $response = $this->post('/register/usuario', [
            'nome' => 'Novo Usuario',
            'email' => 'novo@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'codigo_facilitador' => 'INVALIDO',
        ]);

        $response->assertSessionHasErrors('codigo_facilitador');
        $this->assertDatabaseMissing('usuarios', [
            'email' => 'novo@test.com',
        ]);
    }

    /** @test */
    public function usuario_pode_fazer_logout()
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
        $this->assertAuthenticated('web');

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest('web');
    }
}
