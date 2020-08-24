<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';

    protected $fillable = [
        'nome_fantasia',
        'razao_social',
        'email',
        'cnpj',
        'telefone'
    ];
}
