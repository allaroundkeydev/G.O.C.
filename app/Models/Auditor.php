<?php
//app\Models\Auditor.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auditor extends Model
{
    
    use HasFactory, SoftDeletes;
    protected $table = 'auditores';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'telefono',
        'correo_electronico',
        'empresa',
        'num_vpcpa',
        'nombrado',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'nombrado' => 'boolean',
    ];

    /**
     * Get the tareas clientes associated with this auditor.
     */

    public function clientes()
{
    return $this->belongsToMany(Cliente::class, 'cliente_auditor', 'auditor_id', 'cliente_id')
                ->using(ClienteAuditor::class)
                ->withPivot(['id','fecha_nombramiento','fecha_fin_nombramiento','activo','notas'])
                ->withTimestamps();
}


    public function tareasClientes()
    {
        return $this->hasMany(TareaCliente::class, 'auditor_id');
    }

    /**
     * Get the tareas instancias associated with this auditor.
     */
    public function instancias()
    {
        return $this->hasMany(TareaInstancia::class, 'auditor_id');
    }
}