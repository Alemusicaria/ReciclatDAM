<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Premi extends Model
{
    protected $table = 'premis';
    public $timestamps = false;

    protected $fillable = [
        'nom', 'descripcio', 'punts_requerits'
    ];
}