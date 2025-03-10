<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Codi extends Model
{
    protected $table = 'codis';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'codi', 'punts', 'data_escaneig'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}