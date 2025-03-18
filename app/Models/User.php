<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nom', 'cognoms', 'data_naieixement', 'telefon', 'ubicacio', 'punts_totals', 'punts_actuals', 'punts_gastats', 'email', 'password', 'rol_id', 'foto_perfil'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function codis()
    {
        return $this->hasMany(Codi::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }
}