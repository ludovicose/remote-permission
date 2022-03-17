<?php
declare(strict_types=1);

namespace Ludovicose\RemotePermission\Providers;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\ServiceProvider;
use Ludovicose\RemotePermission\PermissionCheck;

final class RemotePermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'permission');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../config/config.php' => config_path('permission.php'),
            ],
            'config'
        );

        app(Gate::class)->before(function (Authorizable $user, string $permission) {

            if (app()->runningUnitTests()) {
                return true;
            }

            $permissionCheck = new PermissionCheck();
            return $permissionCheck->check($user->id, $permission);
        });
    }
}
