<?php
// app/Models/Tarea.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarea extends Model
{
    use HasFactory, SoftDeletes;

    // Si tu tabla se llama “tareas” no es necesario, pero lo dejo para que quede explícito
    protected $table = 'tareas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'institucion_id',
        'created_by',
    ];

    protected $casts = [
        'institucion_id' => 'integer',
        'created_by'     => 'integer',
        'deleted_at'     => 'datetime',
    ];

    /**
     * La institución (Alcaldía, Hacienda…) a la que pertenece esta plantilla.
     */
    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    /**
     * El usuario (contador/admin) que creó esta plantilla.
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Los campos dinámicos que definen el formulario de esta plantilla.
     */
    public function campos()
    {
        // Ordenamos por la posición que definiste en la columna `orden`
        return $this->hasMany(TareaCampo::class, 'tarea_id')
                    ->orderBy('orden');
    }

    /**
     * Las asignaciones de esta plantilla a clientes (tareas_clientes).
     */
    public function asignaciones()
    {
        return $this->hasMany(TareaCliente::class, 'tarea_id');
    }

    /**
     * Todas las instancias concretas (tareas_instancias) derivadas de esta plantilla.
     */
    public function instancias()
    {
        return $this->hasMany(TareaInstancia::class, 'tarea_id');
    }

    /**
     * Scope para plantillas activas (no “eliminadas”).
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}