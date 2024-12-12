<?php

namespace App\Providers;

use App\Models\Company;
use App\Policies\CompanyPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * El arreglo de políticas que se pueden registrar.
     *
     * @var array
     */
    protected $policies = [
        Company::class => CompanyPolicy::class, // Aquí registras la política
    ];

    /**
     * Registra los servicios de autorización.
     *
     * @return void
     */

    public function boot(): void
    {
        $this->registerPolicies();

        Passport::loadKeysFrom(storage_path('oauth'));

        // Optional: Define token expiration times
        Passport::tokensExpireIn(now()->addDays(1));
        Passport::refreshTokensExpireIn(now()->addDays(30));
    }
}
