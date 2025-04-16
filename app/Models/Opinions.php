<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Opinions extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['autor', 'comentari', 'estrelles'];

    /**
     * Configuració per a Algolia.
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'autor' => $this->autor,
            'comentari' => $this->comentari,
            'estrelles' => $this->estrelles,
        ];
    }
}