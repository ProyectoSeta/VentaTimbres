<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Cantera extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    protected $fillable = [
        'id_sujeto',
        'nombre',
        'municipio_parroquia',
        'lugar_aprovechamiento',
        'status',
        'observaciones',
    ];

    public function produccions(){
        return $this->hasMany(Produccion::class,'id_cantera', 'id_cantera');
    }
}
