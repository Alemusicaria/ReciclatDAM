<?php

namespace App\Models;

use App\Support\AutoTranslator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

class PuntDeRecollida extends Model
{
    use HasFactory, Searchable;

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

    public function displayNom(): string
    {
        return AutoTranslator::translate($this->getRawOriginal('nom'), 'collection_points_db_names') ?? $this->getRawOriginal('nom');
    }

    public function displayFraccio(): string
    {
        $fraccio = (string) ($this->getRawOriginal('fraccio') ?? '');
        $key = $this->fractionTranslationKey($fraccio);

        return $key ? __('messages.categories.nom.' . $key) : $fraccio;
    }

    private function fractionTranslationKey(string $fraccio): ?string
    {
        $normalized = Str::slug(Str::ascii($fraccio));

        return match ($normalized) {
            'deixalleria', 'punt-verd', 'waste-collection' => 'waste_collection',
            'envasos', 'packaging' => 'packaging',
            'especial', 'special' => 'special',
            'medicaments', 'medication', 'medicines' => 'medication',
            'organica', 'organic' => 'organic',
            'paper' => 'paper',
            'piles', 'batteries' => 'batteries',
            'raee', 'weee' => 'raee',
            'resta', 'rest' => 'rest',
            'vidre', 'glass' => 'glass',
            default => null,
        };
    }

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