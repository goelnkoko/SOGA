<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Profile;
use App\Policies\ProfilePolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registre as políticas aqui
        $this->registerPolicies();

        Gate::policy(Profile::class, ProfilePolicy::class);
    }

    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Mapeamento de políticas
        Profile::class => ProfilePolicy::class,
    ];
}
