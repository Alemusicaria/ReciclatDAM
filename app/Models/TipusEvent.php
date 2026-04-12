<?php

namespace App\Models;

use App\Support\AutoTranslator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class TipusEvent extends Model
{
    use HasFactory, Searchable;
    
    protected $table = 'tipus_events';
    
    protected $fillable = ['nom', 'descripcio', 'color'];
    
    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        
        // Agregar conteo de eventos para este tipo
        $array['events_count'] = $this->events()->count();
        
        return $array;
    }
    
    public function events()
    {
        return $this->hasMany(Event::class, 'tipus_event_id');
    }

    public function displayName(): string
    {
        return AutoTranslator::translate($this->getRawOriginal('nom'), 'events_types_db_names') ?? $this->getRawOriginal('nom');
    }

    public function displayDescription(): ?string
    {
        return AutoTranslator::translate($this->getRawOriginal('descripcio'), 'events_db_descriptions') ?? $this->getRawOriginal('descripcio');
    }
}