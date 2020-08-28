<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function produtosVenda()
    {
        return $this->hasMany(ProdutoVenda::class);
    }
}
