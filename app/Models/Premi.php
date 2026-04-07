<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Premi extends Model
{
    use HasFactory, Searchable;

    protected $table = 'premis';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'descripcio',
        'punts_requerits',
        'imatge',
        'categoria',
        'stock',
        'temps_enviament',
        'rating'
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
            'categoria' => $this->categoria ?? 'accessories',
            'stock' => $this->stock ?? 10,
            'temps_enviament' => $this->temps_enviament ?? '3-5 dies',
            'rating' => $this->rating ?? 4.5,
        ];
    }
    public function premiReclamats()
    {
        return $this->hasMany(PremiReclamat::class, 'premi_id');
    }

}