<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class TipusAlerta extends Model
{
    use Searchable;

    protected $table = 'tipus_alertes';

    protected $fillable = [
        'nom',
    ];

    /**
     * Configura els camps que es sincronitzaran amb Algolia.
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
        ];
    }

    public function alertes()
    {
        return $this->hasMany(AlertaPuntDeRecollida::class, 'tipus_alerta_id');
    }
}