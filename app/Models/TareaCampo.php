<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TareaCampo extends Model
{
    use HasFactory;

    protected $table = 'tareas_campos';

    protected $fillable = [
        'tarea_id',
        'nombre',
        'etiqueta',
        'descripcion',
        'tipo',
        'obligatorio',
        'opciones',
        'orden',
        'meta',
    ];

    protected $casts = [
        'obligatorio' => 'boolean',
        'opciones' => 'array',
        'meta' => 'array',
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }

    public function valores()
    {
        return $this->hasMany(TareaInstanciaValor::class, 'campo_id');
    }
}
