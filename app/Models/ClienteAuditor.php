<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClienteAuditor extends Pivot
{
    protected $table = 'cliente_auditor';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps   = true;

    protected $fillable = [
        'cliente_id',
        'auditor_id',
        'fecha_nombramiento',
        'fecha_fin_nombramiento',
        'activo',
        'notas',
    ];

    protected $casts = [
        'id'                      => 'integer',
        'cliente_id'              => 'integer',
        'auditor_id'              => 'integer',
        'fecha_nombramiento'      => 'date',
        'fecha_fin_nombramiento'  => 'date',
        'activo'                  => 'boolean',
        'created_at'              => 'datetime',
        'updated_at'              => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function auditor()
    {
        return $this->belongsTo(Auditor::class, 'auditor_id');
    }
}