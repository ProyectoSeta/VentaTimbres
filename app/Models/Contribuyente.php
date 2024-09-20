<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribuyente extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_contribuyente';
    protected $fillable = ['identidad_condicion',
                            'identidad_nro',
                            'nombre_razon'];
}
