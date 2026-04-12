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

    public function displayName(): string
    {
        return AutoTranslator::translate($this->getRawOriginal('nom'), 'products_db_names') ?? $this->getRawOriginal('nom');
    }

    public function displayCategory(): string
    {
        $category = (string) ($this->getRawOriginal('categoria') ?? '');
        $key = $this->getCategoryTranslationKey($category);

        return $key ? __('messages.categories.nom.' . $key) : $category;
    }

    private function getCategoryTranslationKey(string $category): ?string
    {
        $normalized = Str::slug(Str::ascii($category));

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