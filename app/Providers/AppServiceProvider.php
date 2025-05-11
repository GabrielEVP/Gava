<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\PDFGeneratorInterface;
use App\Services\DomPDFGenerator;
class AppServiceProvider extends ServiceProvider
{




    public function register()
    {
        $this->app->bind(PDFGeneratorInterface::class, DomPDFGenerator::class);
    }




    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
