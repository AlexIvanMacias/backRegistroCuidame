<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evento extends Model
{
    use HasFactory;
    protected $table = 'evento';
    protected $primaryKey = 'id_evento';
    protected $fillable = [
        'id_evento','id_empresa','id_persona','temp',
    ];
}
