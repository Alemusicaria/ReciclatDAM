<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Nivell extends Model
{
    use Searchable;

    protected $table = 'nivells';

    protected $fillable = [
        'nom',
        'punts_requerits',
        'descripcio',
        'icona',
        'color'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function toSearchableArray()
    {
        return $this->toArray();
    }
}