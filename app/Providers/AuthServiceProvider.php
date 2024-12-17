<?php

namespace App\Providers;

use App\Models\Company;
use App\Policies\CompanyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * El arreglo de políticas que se pueden registrar.
     *
     * @var array
     */
    protected $policies = [
        Company::class => CompanyPolicy::class,
    ];

    /**
     * Registra los servicios de autorización.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
