<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class PremiReclamat extends Model
{
    use HasFactory, Searchable;

    protected $table = 'premis_reclamats';

    protected $fillable = [
        'user_id',
        'premi_id',
        'punts_gastats',
        'data_reclamacio',
        'estat',
        'codi_seguiment',
        'comentaris'
    ];

    protected $casts = [
        'data_reclamacio' => 'datetime',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        
        // Añadir información del premio
        $array['premi_nom'] = $this->premi ? $this->premi->nom : null;
        $array['premi_descripcio'] = $this->premi ? $this->premi->descripcio : null;
        
        // Añadir información del usuario
        $array['user_nom'] = $this->user ? $this->user->nom : null;
        $array['user_cognoms'] = $this->user ? $this->user->cognoms : null;
        $array['user_email'] = $this->user ? $this->user->email : null;
        
        // Formateo de fechas
        $array['data_reclamacio_formatted'] = $this->data_reclamacio ? $this->data_reclamacio->format('Y-m-d H:i:s') : null;
        
        return $array;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function premi()
    {
        return $this->belongsTo(Premi::class);
    }
}