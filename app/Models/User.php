<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'nombre_completo',
        'username',
        'password',
        'telefono',
        'email',
        'rol',
        'estado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // CORRECCIÓN: usar propiedad $casts (no método)
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    public function isContador(): bool
    {
        return $this->rol === 'contador';
    }

    public function tareasAsignadas()
    {
        return $this->hasMany(TareaCliente::class, 'contador_id');
    }

    public function instanciasAsignadas()
    {
        return $this->hasMany(TareaInstancia::class, 'contador_id');
    }
}
