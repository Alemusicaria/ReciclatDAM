<?php

namespace App\Models;

use App\Support\AutoTranslator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

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

    public function displayNom(): string
    {
        return AutoTranslator::translate($this->getRawOriginal('nom'), 'prizes_db_names') ?? $this->getRawOriginal('nom');
    }

    public function displayDescripcio(): ?string
    {
        return AutoTranslator::translate($this->getRawOriginal('descripcio'), 'prizes_db_descriptions') ?? $this->getRawOriginal('descripcio');
    }

    public function displayCategoria(): string
    {
        $categoria = (string) ($this->getRawOriginal('categoria') ?? '');
        $key = $this->categoryTranslationKey($categoria);

        return $key ? __('messages.awards_ui.category_' . $key) : $categoria;
    }

    private function categoryTranslationKey(string $categoria): ?string
    {
        $normalized = Str::slug(Str::ascii($categoria));

        return match ($normalized) {
            'electr-nica', 'electronics', 'electronic' => 'electronics',
            'transport' => 'transport',
            'accessoris', 'accessories' => 'accessories',
            'esports', 'sports' => 'sports',
            'casa', 'home' => 'home',
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