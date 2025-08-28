<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments'; // o 'adjuntos' si prefieres español

    protected $fillable = [
        'instancia_id',   // nullable -> vinculado a una tarea_instancia
        'cliente_id',     // nullable -> vinculado directamente a cliente
        'tipo',           // ej. 'contrato_mt', 'comprobante_iva', 'archivo_general'
        'ruta',           // path en storage (ej: attachments/...)
        'nombre_original',
        'mime',
        'tamano',
        'uploaded_by',    // user_id que subió el archivo
    ];

    protected $casts = [
        'instancia_id' => 'integer',
        'cliente_id' => 'integer',
        'tamano' => 'integer',
        'uploaded_by' => 'integer',
    ];

    /**
     * Relación opcional a instancia de tarea (si aplica).
     */
    public function instancia()
    {
        return $this->belongsTo(TareaInstancia::class, 'instancia_id');
    }

    /**
     * Relación opcional a cliente (si el archivo está a nivel cliente).
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Usuario que subió el archivo.
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
