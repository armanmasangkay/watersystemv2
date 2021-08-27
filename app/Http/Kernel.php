<?php

namespace App\Http;

use App\Http\Middleware\AllowedAccess;
use App\Http\Middleware\AllowedAccessGroupAdmin;
use App\Http\Middleware\AllowedAccessGroupMeterReader;
use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\IsCashier;
use App\Http\Middleware\RestricCashier;
use App\Http\Middleware\AllowedBldgInspectorAccess;
use App\Http\Middleware\AllowedAdminCashierAccess;
use App\Http\Middleware\AllowedWaterworksInspector;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'access.authorize'=>EnsureIsAdmin::class,
        'auth.restrict-cashier'=>RestricCashier::class,
        'auth.allowed-user' => AllowedAccessGroupAdmin::class,
        'auth.allowed-reader' => AllowedAccessGroupMeterReader::class,
        'auth.allowed-bldg-inspector' => AllowedBldgInspectorAccess::class,
        'auth.allowed-admin-cashier-access' => AllowedAdminCashierAccess::class,
        'auth.allowed-waterworks-access' => AllowedWaterworksInspector::class
    ];
}
