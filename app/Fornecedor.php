<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}
