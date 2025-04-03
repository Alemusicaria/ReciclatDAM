<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Producte extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['nom', 'categoria', 'imatge'];

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