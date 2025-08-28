<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'instancia_id',
        'tipo',
        'destinatario',
        'umbral_days_before',
        'enviado',
        'enviado_at',
        'payload',
    ];

    protected $casts = [
        'enviado' => 'boolean',
        'enviado_at' => 'datetime',
        'payload' => 'array',
    ];

    public function instancia()
    {
        return $this->belongsTo(TareaInstancia::class, 'instancia_id');
    }
}
