<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Opinions extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'autor',
        'comentari',
        'estrelles',
        'user_id',
        'producte_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Configuració per a Algolia.
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'autor' => $this->autor,
            'comentari' => $this->comentari,
            'estrelles' => (float)$this->estrelles,
            'user_id' => $this->user_id,
            'producte_id' => $this->producte_id,
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : now()->toDateTimeString(),
        ];
    }
}