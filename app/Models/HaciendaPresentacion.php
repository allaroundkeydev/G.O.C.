<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HaciendaPresentacion extends Model
{
    use HasFactory;

    protected $table = 'hacienda_presentaciones';

    protected $fillable = [
        'cliente_id',
        'tipo_presentacion',
        'fecha_presentacion',
        'monto',
        'observaciones',
    ];

    protected $casts = [
        'fecha_presentacion' => 'date',
        'monto' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
