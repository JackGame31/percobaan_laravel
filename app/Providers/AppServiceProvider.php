<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // menambah pemberitahuan kalau paginator kita pakai bootstrap
        Paginator::useBootstrap();

        // menambah gate untuk fleksible middleware dipakai di sidebar
        /* define gate bernama admin
         * parameter function selalu user, laravel otomatis tau user yang login sekarang siapa
         * di cek usernamenya admin atau tidak
         */
        Gate::define('admin', function(User $user){
            // column baru di table. Ketika bernilai true, maka akan bernilai true direturn
            return $user->is_admin;
        });
    }
}
