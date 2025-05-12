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
        'adreca',
        'latitud',
        'longitud',
        'fraccio',
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
            'adreca' => $this->adreca,
            'latitud' => $this->latitud,
            'longitud' => $this->longitud,
            'fraccio' => $this->fraccio,
            'disponible' => $this->disponible,
        ];
    }

    public function alertes()
    {
        return $this->hasMany(AlertaPuntDeRecollida::class, 'punt_de_recollida_id');
    }
}