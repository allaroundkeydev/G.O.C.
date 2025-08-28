<?php

// app/Models/Representante.php (sugerencia)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Representante extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'fecha_nacimiento',
        'telefono',
        'correo_electronico',
        'dui',
        'fecha_nombramiento',
        'duracion_meses',
        'fecha_fin_nombramiento',
        'numero_acta',
        'numero_acuerdo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_nombramiento' => 'date',
        'fecha_fin_nombramiento' => 'date',
    ];

    /**
     * Clientes a los que está vinculado (pivote cliente_representante).
     */
    public function clientes()
    {
        return $this->belongsToMany(
            Cliente::class,
            'cliente_representante',
            'representante_id',
            'cliente_id'
        )->withTimestamps();
    }

    /**
     * Instancias de tarea que involucren a este representante.
     */
    public function instancias()
    {
        return $this->hasMany(TareaInstancia::class, 'representante_id');
    }
}
