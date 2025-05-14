<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Event extends Model
{
    use Searchable;

    protected $fillable = [
        'nom',
        'descripcio',
        'data_inici',
        'data_fi',
        'lloc',
        'tipus_event_id',
        'capacitat',
        'punts_disponibles',
        'actiu',
        'imatge'
    ];

    protected $casts = [
        'data_inici' => 'datetime',
        'data_fi' => 'datetime',
        'actiu' => 'boolean',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    // En App\Models\Event.php
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Agregar el tipo para facilitar la búsqueda
        $array['tipus_nom'] = $this->tipus ? $this->tipus->nom : null;
        $array['tipus_color'] = $this->tipus ? $this->tipus->color : null;

        // Convertir fechas a strings para Algolia
        $array['data_inici_formatted'] = $this->data_inici ? $this->data_inici->format('Y-m-d H:i:s') : null;
        $array['data_fi_formatted'] = $this->data_fi ? $this->data_fi->format('Y-m-d H:i:s') : null;

        // Añadir participantes y su información
        $array['participants_count'] = $this->participants()->count();

        // Si el usuario está autenticado, verificar si está registrado
        if (auth()->check()) {
            $array['user_registered'] = $this->participants()->where('user_id', auth()->id())->exists();
        } else {
            $array['user_registered'] = false;
        }

        // Opcional: lista de IDs de participantes
        $array['participant_ids'] = $this->participants()->pluck('users.id')->toArray();

        return $array;
    }

    public function tipus()
    {
        return $this->belongsTo(TipusEvent::class, 'tipus_event_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_user')
            ->withPivot('punts', 'producte_id', 'created_at')
            ->withTimestamps();
    }

    /**
     * Obtener solo eventos futuros
     */
    public function scopeFuture($query)
    {
        return $query->where('data_inici', '>=', now());
    }

    /**
     * Obtener solo eventos pasados
     */
    public function scopePast($query)
    {
        return $query->where('data_inici', '<', now());
    }
    public function producte()
    {
        return $this->belongsTo(Producte::class, 'producte_id');
    }
}