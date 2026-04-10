<?php

namespace App\Models;

use App\Support\AutoTranslator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'rols';

    protected $fillable = ['nom'];

    public function displayNom(): string
    {
        return AutoTranslator::translate($this->getRawOriginal('nom'), 'roles_db_names') ?? $this->getRawOriginal('nom');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}