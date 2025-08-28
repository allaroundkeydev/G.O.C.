<?php
//app\Models\Institucion.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'instituciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Get the tareas associated with this institucion.
     */
    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'institucion_id');
    }

    /**
     * Get the tareas clientes associated with this institucion.
     */
    public function tareasClientes()
    {
        return $this->hasMany(TareaCliente::class, 'institucion_id');
    }
}