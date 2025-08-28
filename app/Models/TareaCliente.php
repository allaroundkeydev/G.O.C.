<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TareaCliente extends Model
{
    use HasFactory;

    protected $table = 'tareas_clientes';

    protected $fillable = [
        'tarea_id',
        'cliente_id',
        'contador_id',
        'auditor_id',
        'representante_id',
        'institucion_id',
        'recurrence_rule',
        'alerta_dias_antes',
        'activo',
    ];

    protected $casts = [
        'alerta_dias_antes' => 'integer',
        'activo' => 'boolean',
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function contador()
    {
        return $this->belongsTo(User::class, 'contador_id');
    }

    public function auditor()
    {
        return $this->belongsTo(Auditor::class, 'auditor_id');
    }

    public function representante()
    {
        return $this->belongsTo(Representante::class, 'representante_id');
    }

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }

    public function instancias()
    {
        return $this->hasMany(TareaInstancia::class, 'tarea_cliente_id');
    }
}
