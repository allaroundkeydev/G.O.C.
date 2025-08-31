<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TareaInstanciaValor extends Model
{
    use HasFactory;

    protected $table = 'tareas_instancia_valores';

    protected $fillable = [
        'instancia_id',
        'campo_id',
        'valor_text',
        'valor_num',
        'valor_fecha',
        'valor_bool',
        'valor_entity_type',
        'valor_entity_id',
    ];

    protected $casts = [
        'valor_fecha'         => 'date',
        'valor_bool'          => 'boolean',
        'valor_num'           => 'decimal:2',
        'valor_entity_id'     => 'integer',
    ];

    // Relación a la instancia de tarea
    public function instancia()
    {
        return $this->belongsTo(TareaInstancia::class, 'instancia_id');
    }

    // Relación al campo de la plantilla
    public function campo()
    {
        return $this->belongsTo(TareaCampo::class, 'campo_id');
    }

    // (Opcional) Polimórfica para valor_entity_type/valor_entity_id
    public function entidad()
    {
        return $this->morphTo(
            'valor_entity', 
            'valor_entity_type', 
            'valor_entity_id'
        );
    }
}
