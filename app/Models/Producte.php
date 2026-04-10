<?php
namespace App\Models;

use App\Support\AutoTranslator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

class Producte extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['nom', 'categoria', 'imatge'];

    public function displayNom(): string
    {
        return AutoTranslator::translate($this->getRawOriginal('nom'), 'products_db_names') ?? $this->getRawOriginal('nom');
    }

    public function displayCategoria(): string
    {
        $categoria = (string) ($this->getRawOriginal('categoria') ?? '');
        $key = $this->categoryTranslationKey($categoria);

        return $key ? __('messages.categories.nom.' . $key) : $categoria;
    }

    private function categoryTranslationKey(string $categoria): ?string
    {
        $normalized = Str::slug(Str::ascii($categoria));

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

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'categoria' => $this->categoria,
            'imatge' => $this->imatge,
        ];
    }
}