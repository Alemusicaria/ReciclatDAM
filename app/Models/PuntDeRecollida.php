<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class PuntDeRecollida extends Model
{
    use Searchable;

    protected $table = 'punts_de_recollida';

    protected $fillable = [
        'nom',
        'ciutat',
        'adreça',
        'latitud',
        'longitud',
        'fracció',
        'disponible',
    ];

    /**
     * Configura els camps que es sincronitzaran amb Algolia.
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'ciutat' => $this->ciutat,
            'adreça' => $this->adreça,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'fracció' => $this->fracció,
            'disponible' => $this->disponible,
        ];
    }

    public function alertes()
    {
        return $this->hasMany(AlertaPuntDeRecollida::class, 'punt_de_recollida_id');
    }
}