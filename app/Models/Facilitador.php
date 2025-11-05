<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Facilitador extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nome',
        'email',
        'password',
        'codigo_indicacao',
        'ativo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    // Relacionamento: Um facilitador tem muitos usuários
    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }

    // Pegar todas as notas dos usuários indicados por este facilitador
    public function notasFiscais()
    {
        return $this->hasManyThrough(NotaFiscal::class, Usuario::class);
    }
}
