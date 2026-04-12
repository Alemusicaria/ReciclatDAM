<?php

namespace App\Models;

use App\Support\AutoTranslator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class TipusAlerta extends Model
{
    use HasFactory, Searchable;

    protected $table = 'tipus_alertes';

    protected $fillable = [
        'nom',
    ];

    public function displayName(): string
    {
        return AutoTranslator::translate($this->getRawOriginal('nom'), 'alert_types_db_names') ?? $this->getRawOriginal('nom');
    }

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