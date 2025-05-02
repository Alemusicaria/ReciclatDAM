<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class AlertaPuntDeRecollida extends Model
{
    use Searchable;

    protected $table = 'alertes_punts_de_recollida';

    protected $fillable = [
        'punt_de_recollida_id',
        'tipus_alerta_id',
        'descripció',
        'imatge',
    ];

    /**
     * Configura els camps que es sincronitzaran amb Algolia.
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'punt_de_recollida_id' => $this->punt_de_recollida_id,
            'tipus_alerta_id' => $this->tipus_alerta_id,
            'descripció' => $this->descripció,
            'imatge' => $this->imatge,
        ];
    }

    public function puntDeRecollida()
    {
        return $this->belongsTo(PuntDeRecollida::class, 'punt_de_recollida_id');
    }

    public function tipus()
    {
        return $this->belongsTo(TipusAlerta::class, 'tipus_alerta_id');
    }
}