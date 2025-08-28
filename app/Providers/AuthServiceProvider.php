<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Tarea;
use App\Models\TareaCampo;
use App\Models\TareaCliente;
use App\Models\TareaInstancia;
use App\Models\IvaDeclaracion;
use App\Models\HaciendaPresentacion;
use App\Models\MtContrato;
use App\Policies\UserPolicy;
use App\Policies\ClientePolicy;
use App\Policies\TareaPolicy;
use App\Policies\TareaCampoPolicy;
use App\Policies\TareaClientePolicy;
use App\Policies\TareaInstanciaPolicy;
use App\Policies\IvaDeclaracionPolicy;
use App\Policies\HaciendaPresentacionPolicy;
use App\Policies\MtContratoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Cliente::class => ClientePolicy::class,
        Tarea::class => TareaPolicy::class,
        TareaCampo::class => TareaCampoPolicy::class,
        TareaCliente::class => TareaClientePolicy::class,
        TareaInstancia::class => TareaInstanciaPolicy::class,
        IvaDeclaracion::class => IvaDeclaracionPolicy::class,
        HaciendaPresentacion::class => HaciendaPresentacionPolicy::class,
        MtContrato::class => MtContratoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
