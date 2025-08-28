<?php
//app\Models\Tarea.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarea extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'institucion_id',
        'created_by',
    ];

    /**
     * Get the institucion that owns this tarea.
     */
    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'institucion_id');
    }

    /**
     * Get the user who created this tarea.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the campos for this tarea.
     */
    public function campos()
    {
        return $this->hasMany(TareaCampo::class, 'tarea_id');
    }

    /**
     * Get the tareas clientes for this tarea.
     */
    public function tareasClientes()
    {
        return $this->hasMany(TareaCliente::class, 'tarea_id');
    }

    /**
     * Get the tareas instancias for this tarea.
     */
    public function instancias()
    {
        return $this->hasMany(TareaInstancia::class, 'tarea_id');
    }
}