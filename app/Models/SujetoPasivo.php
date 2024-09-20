<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SujetoPasivo extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_sujeto';
    protected $fillable = ['id_user',
                            'rif_condicion',
                            'rif_nro',
                            'artesanal',
                            'razon_social',
                            'direccion',
                            'tlf_movil',
                            'tlf_fijo',
                            'ci_condicion_repr',
                            'ci_nro_repr',
                            'rif_condicion_repr',
                            'rif_nro_repr',
                            'name_repr',
                            'tlf_repr'];
    // Se tiene que colocar los nombre de los campos de forma protegida para poder hacer la insercion de forma efectiva.
}
