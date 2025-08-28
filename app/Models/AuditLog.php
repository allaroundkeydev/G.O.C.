<?php
//app\Models\AuditLog.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'entidad',
        'entidad_id',
        'accion',
        'usuario_id',
        'detalles',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'detalles' => 'array',
    ];

    /**
     * Get the user who created this audit log.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}