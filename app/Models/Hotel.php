<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    /**
     * Campos da tabela no banco de dados
     *
     * @var string[]
     */
    protected $fillable = [
        'address',
        'lat',
        'lng',
        'price',
    ];
}
