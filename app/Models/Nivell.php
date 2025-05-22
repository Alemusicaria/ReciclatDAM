<?php
namespace App\Models;

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