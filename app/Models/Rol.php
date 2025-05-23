<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'rols';

    protected $fillable = ['nom'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}