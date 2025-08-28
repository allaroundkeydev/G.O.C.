<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    public $timestamps = true;

    protected $fillable = [
        'key',         // ej. 'alerta_umbral_default'
        'value',       // valor serializado o json
        'type',        // 'string','int','json','boolean'
        'descripcion',
        'updated_by',  // user_id que modificó
    ];

    protected $casts = [
        'value' => 'array', // asume que guardamos JSON; si guardas string, cambia a 'string'
        'updated_by' => 'integer',
    ];

    /**
     * Obtener valor con fallback.
     */
    public static function getValue(string $key, $default = null)
    {
        $s = static::where('key', $key)->first();
        return $s ? ($s->value ?? $default) : $default;
    }
}
