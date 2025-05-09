<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class TipusEvent extends Model
{
    use Searchable;
    
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
}