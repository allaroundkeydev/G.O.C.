<?php
//app\Models\ClienteActividad.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteActividad extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cliente_actividad';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cliente_id',
        'actividad_id',
    ];

    /**
     * Get the cliente that owns this cliente actividad.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Get the actividad economica that owns this cliente actividad.
     */
    public function actividad()
    {
        return $this->belongsTo(ActividadEconomica::class, 'actividad_id');
    }
}