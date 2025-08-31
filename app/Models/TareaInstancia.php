<?php
// app/Models/TareaInstancia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TareaInstancia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tareas_instancias';

    const STATUS_PENDING    = 'PENDIENTE';
    const STATUS_COMPLETED  = 'REALIZADA';
    const STATUS_OVERDUE    = 'CADUCADA';

    protected $fillable = [
        'tarea_id',
        'tarea_cliente_id',
        'cliente_id',
        'contador_id',
        'auditor_id',
        'representante_id',
        'estado',
        'fecha_vencimiento',
        'fecha_realizacion',
        'notas',
        'datos_snapshot',
    ];

    protected $casts = [
        'fecha_vencimiento' => 'datetime',
        'fecha_realizacion' => 'datetime',
        'datos_snapshot'    => 'array',
    ];

    // Relaciones

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }

    public function tareaCliente()
    {
        return $this->belongsTo(TareaCliente::class, 'tarea_cliente_id');
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

    public function valores()
    {
        return $this->hasMany(TareaInstanciaValor::class, 'instancia_id');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'instancia_id');
    }

    // Scopes

    public function scopePending($query)
    {
        return $query->where('estado', self::STATUS_PENDING);
    }

    public function scopeCompleted($query)
    {
        return $query->where('estado', self::STATUS_COMPLETED);
    }

    public function scopeOverdue($query)
    {
        return $query->where('estado', self::STATUS_PENDING)
                     ->where('fecha_vencimiento', '<', now());
    }

    public function scopeDueInDays($query, int $days)
    {
        return $query->where('estado', self::STATUS_PENDING)
                     ->whereBetween('fecha_vencimiento', [now(), now()->addDays($days)]);
    }
}