<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdutoVenda extends Model
{
    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function venda()
    {
        return $this->belongsTo(Venda::class);
    }
}
