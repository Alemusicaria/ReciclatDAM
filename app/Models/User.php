<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable;

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
        'data_naixement' => 'date',
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

    public function activities()
    {
        return $this->hasMany(Activity::class);
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

    public function isAdmin(): bool
    {
        $this->loadMissing('rol');

        if (!$this->rol) {
            return false;
        }

        $roleName = mb_strtolower(trim((string) $this->rol->getRawOriginal('nom')));

        return in_array($roleName, ['admin', 'administrador'], true);
    }

    public function profilePhotoUrl(): string
    {
        $photo = trim((string) ($this->foto_perfil ?? ''));

        if ($photo !== '') {
            if (Str::startsWith($photo, ['http://', 'https://'])) {
                return $photo;
            }

            if (Storage::disk('public')->exists($photo)) {
                return Storage::url($photo);
            }

            if (file_exists(public_path($photo))) {
                return asset($photo);
            }
        }

        return asset('images/default-profile.png');
    }
}