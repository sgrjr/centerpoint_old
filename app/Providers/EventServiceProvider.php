<?php namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     * php artisan event:generate
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Illuminate\Auth\Events\Logout::class => [
            App\Listeners\ClearSessionAfterUserLogout::class
        ],
        App\Events\UserLoggedIn::class => [
            App\Listeners\UserAlwaysHasACart::class,
            App\Listeners\NotifyCustomerRep::class
        ],
        App\Events\CartWasSubmitted::class => [
            App\Listeners\UserAlwaysHasACart::class,
            App\Listeners\NotifyCustomerRep::class
        ]
    ];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        //
    }

}
