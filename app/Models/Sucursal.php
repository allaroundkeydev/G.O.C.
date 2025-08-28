<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales';

    protected $fillable = [
        'cliente_id',
        'referencia',
        'direccion',
        'telefono',
        'codigo_hacienda',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'cliente_id' => 'integer',
    ];

    /**
     * Sucursal pertenece a un cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * (Opcional) Instancias de tareas relacionadas a esta sucursal
     * Si en el futuro quieres ligar instancias a sucursal, agrega foreign key en tareas_instancias.
     */
    public function instancias()
    {
        return $this->hasMany(TareaInstancia::class, 'sucursal_id');
    }
}
