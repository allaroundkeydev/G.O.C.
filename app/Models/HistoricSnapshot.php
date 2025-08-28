<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricSnapshot extends Model
{
    use HasFactory;

    protected $table = 'historic_snapshots';

    public $timestamps = true;

    protected $fillable = [
        'entity',       // ej. 'tareas_instancias'
        'entity_id',
        'snapshot',     // json
        'created_by',
    ];

    protected $casts = [
        'snapshot' => 'array',
        'entity_id' => 'integer',
        'created_by' => 'integer',
    ];
}
