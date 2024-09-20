<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mineral extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_mineral';
    protected $fillable = [
        'mineral',
    ];
}
