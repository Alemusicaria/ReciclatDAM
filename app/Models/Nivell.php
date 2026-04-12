<?php
namespace App\Models;

use App\Support\AutoTranslator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Nivell extends Model
{
    use HasFactory, Searchable;

    protected $table = 'nivells';

    protected $fillable = [
        'nom',
        'punts_requerits',
        'descripcio',
        'icona',
        'color'
    ];

    public function displayName(): string
    {
        return AutoTranslator::translate($this->getRawOriginal('nom'), 'levels_db_names') ?? $this->getRawOriginal('nom');
    }

    public function displayDescription(): ?string
    {
        return AutoTranslator::translate($this->getRawOriginal('descripcio'), 'levels_db_descriptions') ?? $this->getRawOriginal('descripcio');
    }

    /**
     * Relació amb User
     */
    public function users()
    {
        return $this->hasMany(User::class, 'nivell_id');
    }

    /**
     * Per a Laravel Scout
     */
    public function toSearchableArray()
    {
        return $this->toArray();
    }
}