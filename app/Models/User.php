<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nom',
        'cognoms',
        'data_naixement',
        'telefon',
        'ubicacio',
        'punts_totals',
        'punts_actuals',
        'punts_gastats',
        'email',
        'password',
        'rol_id',
        'foto_perfil'
    ];

    protected $hidden = [
        'password',
        'remember_token',
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
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_user')
            ->withPivot('punts', 'producte_id', 'created_at', 'updated_at');
    }

    public function premisReclamats()
    {
        return $this->hasMany(PremiReclamat::class);
    }
    public function nivell()
    {
        $nivells = \App\Models\Nivell::orderBy('punts_requerits', 'desc')->get();

        foreach ($nivells as $nivell) {
            if ($this->punts_totals >= $nivell->punts_requerits) {
                return $nivell;
            }
        }

        // Si por alguna razón no encuentra nivel, devuelve el nivel 1
        return \App\Models\Nivell::where('punts_requerits', 0)->first();
    }
}