<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }
}
