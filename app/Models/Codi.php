<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Codi extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'codi',
        'punts',
        'data_escaneig',
    ];

    protected $casts = [
        'data_escaneig' => 'datetime',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        
        // Añadir datos del usuario si existe
        if ($this->user_id) {
            $user = User::find($this->user_id);
            if ($user) {
                $array['user_nom'] = $user->nom;
                $array['user_cognoms'] = $user->cognoms;
                $array['user_email'] = $user->email;
            }
        }
        
        // Formatear la fecha para mejor búsqueda
        if ($this->data_escaneig) {
            $array['data_escaneig_formatted'] = $this->data_escaneig->format('Y-m-d H:i:s');
            $array['data_escaneig_mes'] = $this->data_escaneig->format('m');
            $array['data_escaneig_any'] = $this->data_escaneig->format('Y');
            
            // Añadir nombre del mes en català
            $meses = ['Gen', 'Feb', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Oct', 'Nov', 'Des'];
            $array['data_escaneig_mes_nom'] = $meses[$this->data_escaneig->format('n') - 1];
        }
        
        return $array;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}