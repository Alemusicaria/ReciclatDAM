<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class Activity extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'action', 'description', 'data'
    ];
    
    protected $casts = [
        'data' => 'array',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public static function log($userId, $action, $description = null, $data = [])
    {
        return self::create([
            'user_id' => $userId,
            'action' => $action,
            'description' => $description,
            'data' => $data
        ]);
    }

    public function getLocalizedActionAttribute()
    {
        $action = (string) ($this->action ?? '');

        $patterns = [
            ['/^Ha actualitzat el perfil de (.+)$/u', 'profile_updated', ['name']],
            ['/^Ha actualizado el perfil de (.+)$/u', 'profile_updated', ['name']],
            ['/^Ha eliminat l\'usuari (.+)$/u', 'user_deleted', ['name']],
            ['/^Ha eliminat user: (.+)$/u', 'user_deleted', ['name']],
            ['/^Ha creat un nou usuari: (.+)$/u', 'user_created', ['name']],
            ['/^Ha creat un nou event: (.+)$/u', 'event_created', ['name']],
            ['/^Ha eliminat event: (.+)$/u', 'event_deleted', ['name']],
            ['/^Ha actualitzat l\'event: (.+)$/u', 'event_updated', ['name']],
            ['/^Ha eliminat premi: (.+)$/u', 'prize_deleted', ['name']],
            ['/^Ha eliminat codi: (.+)$/u', 'code_deleted', ['code']],
            ['/^Ha eliminat producte: (.+)$/u', 'product_deleted', ['name']],
            ['/^Ha creat un nou punt de recollida: (.+)$/u', 'collection_point_created', ['name']],
            ['/^Ha actualitzat el punt de recollida: (.+)$/u', 'collection_point_updated', ['name']],
            ['/^Ha eliminat punt-reciclatge: (.+)$/u', 'collection_point_deleted', ['name']],
            ['/^Ha creat un nou rol: (.+)$/u', 'role_created', ['name']],
            ['/^Ha actualitzat el rol: (.+)$/u', 'role_updated', ['name']],
            ['/^Ha eliminat rol: (.+)$/u', 'role_deleted', ['name']],
            ['/^Ha creat un nou tipus d\'alerta: (.+)$/u', 'alert_type_created', ['name']],
            ['/^Ha actualitzat el tipus d\'alerta: (.+)$/u', 'alert_type_updated', ['name']],
            ['/^Ha eliminat tipus-alerta: (.+)$/u', 'alert_type_deleted', ['name']],
            ['/^Ha actualitzat l\'alerta ID: (\d+)$/u', 'alert_updated_id', ['id']],
            ['/^Ha eliminat alerta-punt: (.+)$/u', 'point_alert_deleted', ['name']],
            ['/^Ha creat una nova alerta per al punt de recollida ID: (\d+)$/u', 'point_alert_created_id', ['id']],
            ['/^Ha creat un nou tipus d\'event: (.+)$/u', 'event_type_created', ['name']],
            ['/^Ha actualitzat el tipus d\'event: (.+)$/u', 'event_type_updated', ['name']],
            ['/^Ha eliminat tipus-event: (.+)$/u', 'event_type_deleted', ['name']],
            ['/^Ha aprovat la sol·licitud de premi #(\d+) per a (.+) amb codi de seguiment: (.+)$/u', 'prize_request_approved_with_tracking', ['id', 'user', 'tracking']],
            ['/^Ha aprovat la sol·licitud de premi #(\d+) per a (.+)$/u', 'prize_request_approved', ['id', 'user']],
            ['/^Ha rebutjat la sol·licitud de premi #(\d+) per a (.+)$/u', 'prize_request_rejected', ['id', 'user']],
            ['/^Ha actualitzat l\'estat del premi reclamat #(\d+) a (.+)$/u', 'claimed_prize_status_updated', ['id', 'status']],
            ['/^Ha escanejat el codi (.+) i ha guanyat (\d+) punts$/u', 'code_scanned_points', ['code', 'points']],
        ];

        foreach ($patterns as [$regex, $key, $fields]) {
            if (!preg_match($regex, $action, $matches)) {
                continue;
            }

            $replacements = [];
            foreach ($fields as $index => $field) {
                $replacements[$field] = $matches[$index + 1] ?? '';
            }

            return __('messages.admin.activity_actions.' . $key, $replacements);
        }

        $langKey = 'messages.admin.activity_actions.' . $action;
        if (Lang::has($langKey)) {
            return __($langKey, (array) ($this->data ?? []));
        }

        return $action;
    }
}