<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaFiscal extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'chave_acesso',
        'cnpj',
        'data_emissao',
        'valor',
        'cidade',
        'ano',
        'mes',
        'modelo',
        'numero_nf',
        'serie',
        'sat',
    ];

    protected $casts = [
        'data_emissao' => 'date',
        'valor' => 'decimal:2',
    ];

    // Relacionamento: Uma nota fiscal pertence a um usuário
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    // Através do usuário, pegar o facilitador
    public function facilitador()
    {
        return $this->hasOneThrough(Facilitador::class, Usuario::class, 'id', 'id', 'usuario_id', 'facilitador_id');
    }
}
