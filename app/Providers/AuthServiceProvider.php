<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    use HasApiTokens;
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        // if (trait_exists(HasApiTokens::class)) {
        //     User::mixin(new HasApiTokens);
        // }
        // Passport::routes();
        Gate::define('assign-tickets', function ($user) {
            return $user->role === 'admin';
        });
    }
}
