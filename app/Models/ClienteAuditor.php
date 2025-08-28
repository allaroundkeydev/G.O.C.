<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClienteAuditor extends Pivot
{
    use HasFactory;

    protected $table = 'cliente_auditor';

    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'cliente_id',
        'auditor_id',
    ];

    protected $casts = [
        'cliente_id' => 'integer',
        'auditor_id' => 'integer',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function auditor()
    {
        return $this->belongsTo(Auditor::class, 'auditor_id');
    }
}
