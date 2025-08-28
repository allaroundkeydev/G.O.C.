<?php
//app\Models\ActividadEconomica.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadEconomica extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'actividad_economica';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo',
        'descripcion',
    ];

    /**
     * Get the clientes associated with this actividad economica.
     */
    public function clientes()
    {
        return $this->belongsToMany(
            Cliente::class,
            'cliente_actividad',
            'actividad_id',
            'cliente_id'
        )->withTimestamps();
    }
}