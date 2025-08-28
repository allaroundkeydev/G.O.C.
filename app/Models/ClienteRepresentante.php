<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClienteRepresentante extends Pivot
{
    use HasFactory;

    protected $table = 'cliente_representante';

    // Si quieres que sea manejable como modelo Eloquent (timestamps true)
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'cliente_id',
        'representante_id',
        // agrega más campos si luego necesitas (fecha_inicio, activo, rol, etc.)
    ];

    protected $casts = [
        'cliente_id' => 'integer',
        'representante_id' => 'integer',
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
