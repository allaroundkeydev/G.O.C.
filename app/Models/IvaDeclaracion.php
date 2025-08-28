<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IvaDeclaracion extends Model
{
    use HasFactory;

    protected $table = 'iva_declaraciones';

    protected $fillable = [
        'cliente_id',
        'periodo_inicio',
        'periodo_fin',
        'fecha_presentacion',
        'monto_a_pagar',
        'plazo',
        'cantidad_cuotas',
        'dia_pago',
    ];

    protected $casts = [
        'periodo_inicio' => 'date',
        'periodo_fin' => 'date',
        'fecha_presentacion' => 'date',
        'monto_a_pagar' => 'decimal:2',
        'plazo' => 'boolean',
        'cantidad_cuotas' => 'integer',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
