<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Premi extends Model
{
    use Searchable;

    protected $table = 'premis';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'descripcio',
        'punts_requerits',
        'imatge'
    ];

    /**
     * Configura els camps que es sincronitzaran amb Algolia.
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'descripcio' => $this->descripcio,
            'punts_requerits' => $this->punts_requerits,
            'imatge' => $this->imatge,
        ];
    }
    public function premiReclamats()
    {
        return $this->hasMany(PremiReclamat::class, 'premi_id');
    }

}