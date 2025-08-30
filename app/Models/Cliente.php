<?php
//app\Models\Cliente.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'razon_social',
        'dui',
        'nit',
        'nrc',
        'fecha_constitucion',
        'fecha_inscripcion',
        'tipo_gobierno',
    ];

    protected $casts = [
        'fecha_constitucion' => 'date',
        'fecha_inscripcion'  => 'date',
    ];

public function auditores()
{
    return $this->belongsToMany(
        Auditor::class,
        'cliente_auditor',
        'cliente_id',
        'auditor_id'
    )
    ->withPivot([
        'fecha_nombramiento',
        'fecha_fin_nombramiento',
        'activo',
        'notas'
    ])
    ->withTimestamps()
    ->orderByDesc('pivot_fecha_nombramiento'); // 👈 ordena por fecha más reciente
}




public function representantes()
{
    return $this->belongsToMany(Representante::class, 'cliente_representante', 'cliente_id', 'representante_id')
                ->using(ClienteRepresentante::class)
                ->withPivot(['id','fecha_nombramiento','duracion_meses','fecha_fin_nombramiento','numero_acta','numero_acuerdo','activo'])
                ->withTimestamps();
}

    public function actividades()
    {
        return $this->belongsToMany(
            ActividadEconomica::class,
            'cliente_actividad',
            'cliente_id',
            'actividad_id'
        );
    }

    /**
     * Get the client accounts for this client.
     */
    public function cuentas()
    {
        return $this->hasMany(ClientAccount::class, 'cliente_id');
    }

    /**
     * Get the tareas clientes for this client.
     */
    public function tareasClientes()
    {
        return $this->hasMany(TareaCliente::class, 'cliente_id');
    }

    /**
     * Get the tareas instancias for this client.
     */
    public function instancias()
    {
        return $this->hasMany(TareaInstancia::class, 'cliente_id');
    }

    /**
     * Get the UIF registros for this client.
     */
    public function uifRegistros()
    {
        return $this->hasMany(UifRegistro::class, 'cliente_id');
    }

    /**
     * Get the MT contratos for this client.
     */
    public function mtContratos()
    {
        return $this->hasMany(MtContrato::class, 'cliente_id');
    }

    /**
     * Get the IVA declaraciones for this client.
     */
    public function ivaDeclaraciones()
    {
        return $this->hasMany(IvaDeclaracion::class, 'cliente_id');
    }

    /**
     * Get the Hacienda presentaciones for this client.
     */
    public function haciendaPresentaciones()
    {
        return $this->hasMany(HaciendaPresentacion::class, 'cliente_id');
    }

    public function getTipoGobiernoLabelAttribute(): string
{
    return match ($this->tipo_gobierno) {
        'administrador_unico' => 'Administrador Único',
        'representante'       => 'Representante Legal',
        default               => 'Sin especificar',
    };
}


/**
     * Asigna un nuevo nombramiento a una relación belongsToMany
     * y marca inactivos los anteriores si el nuevo está vigente.
     *
     * @param string $relation Nombre de la relación (auditores o representantes)
     * @param int $relatedId   ID del auditor o representante
     * @param array $pivotData Datos adicionales del pivote
     * @return void
     */
    public function asignarNombramiento(string $relation, int $relatedId, array $pivotData): void
    {
        // Determinar si el nuevo nombramiento está vigente
        $vigente = empty($pivotData['fecha_fin_nombramiento'])
            || Carbon::parse($pivotData['fecha_fin_nombramiento'])->isFuture();

        if ($vigente) {
            // Marcar inactivos todos los nombramientos activos de este cliente en esa relación
            $this->{$relation}()
                ->wherePivot('activo', true)
                ->updateExistingPivot(
                    $this->{$relation}()
                        ->wherePivot('activo', true)
                        ->pluck($this->{$relation}()->getRelatedPivotKeyName())
                        ->toArray(),
                    ['activo' => false]
                );
        }

        // Guardar el nuevo nombramiento
        $this->{$relation}()->attach($relatedId, array_merge($pivotData, [
            'activo' => $vigente ? true : false,
            'fecha_nombramiento' => $pivotData['fecha_nombramiento'] ?? now(),
        ]));
    }




}