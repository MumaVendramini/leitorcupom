<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nome',
        'email',
        'password',
        'facilitador_id',
        'ativo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    // Relacionamento: Um usuário pertence a um facilitador
    public function facilitador()
    {
        return $this->belongsTo(Facilitador::class);
    }

    // Relacionamento: Um usuário tem muitas notas fiscais
    public function notasFiscais()
    {
        return $this->hasMany(NotaFiscal::class);
    }
}
