<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClienteRepresentante extends Pivot
{
    use HasFactory;

    protected $table = 'cliente_representante';

    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'cliente_id',
        'representante_id',
        'fecha_nombramiento',
        'duracion_meses',
        'fecha_fin_nombramiento',
        'numero_acta',
        'numero_acuerdo',
        'activo',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'integer',
        'cliente_id' => 'integer',
        'representante_id' => 'integer',
        'fecha_nombramiento' => 'date',
        'fecha_fin_nombramiento' => 'date',
        'duracion_meses' => 'integer',
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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
