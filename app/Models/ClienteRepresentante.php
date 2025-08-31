<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ClienteRepresentante extends Pivot
{
    protected $table = 'cliente_representante';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps   = true;

    protected $fillable = [
        'cliente_id',
        'representante_id',
        'fecha_nombramiento',
        'duracion_meses',
        'fecha_fin_nombramiento',
        'numero_acta',
        'numero_acuerdo',
        'activo',
    ];

    protected $casts = [
        'id'                      => 'integer',
        'cliente_id'              => 'integer',
        'representante_id'        => 'integer',
        'fecha_nombramiento'      => 'date',
        'duracion_meses'          => 'integer',
        'fecha_fin_nombramiento'  => 'date',
        'numero_acta'             => 'string',
        'numero_acuerdo'          => 'string',
        'activo'                  => 'boolean',
        'created_at'              => 'datetime',
        'updated_at'              => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function representante()
    {
        return $this->belongsTo(Representante::class, 'representante_id');
    }
}