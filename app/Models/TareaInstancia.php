<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TareaInstancia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tareas_instancias';

    const STATUS_PENDING = 'PENDIENTE';
    const STATUS_REALIZADA = 'REALIZADA';
    const STATUS_APLAZADA = 'APLAZADA';
    const STATUS_FINALIZADA = 'FINALIZADA';
    const STATUS_CADUCADA = 'CADUCADA';

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
        'datos_snapshot' => 'array',
    ];

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

    public function notifications()
    {
        return $this->hasMany(Notificacion::class, 'instancia_id'); // ver nota sobre Notificacion vs Notification
    }

    public function scopePending($query)
    {
        return $query->where('estado', self::STATUS_PENDING);
    }

    public function scopeCompleted($query)
    {
        return $query->whereIn('estado', [self::STATUS_REALIZADA, self::STATUS_FINALIZADA]);
    }

    public function scopeOverdue($query)
    {
        return $query->where('fecha_vencimiento', '<', now())
                     ->where('estado', self::STATUS_PENDING);
    }

    /**
     * Scope for instances due within X days (inclusive).
     */
    public function scopeDueInDays($query, int $days)
    {
        $to = now()->addDays($days)->endOfDay();
        return $query->whereBetween('fecha_vencimiento', [now(), $to])
                     ->where('estado', self::STATUS_PENDING);
    }
}
