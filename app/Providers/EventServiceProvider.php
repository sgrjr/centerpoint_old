<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

//Events
use Illuminate\Auth\Events\Registered;
use App\Events\ItemWasAddedToCart;
use App\Events\CartItemWasUpdated;
use App\Events\FailedWritingToDbf;
use App\Events\NewDbfEntryCreated;
use App\Events\ExistingDbfEntryUpdated;

//Listeners
use App\Listeners\PostToStoreActivity;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        
        //User and Authentication Events
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'Illuminate\Auth\Events\Attempting' => [
            PostToStoreActivity::class
        ],
     
        'Illuminate\Auth\Events\Authenticated' => [
            PostToStoreActivity::class
        ],
     
        'Illuminate\Auth\Events\Login' => [
           PostToStoreActivity::class
        ],
     
        'Illuminate\Auth\Events\Failed' => [
           PostToStoreActivity::class
        ],
     
        'Illuminate\Auth\Events\Validated' => [
            PostToStoreActivity::class
        ],
     
        'Illuminate\Auth\Events\Verified' => [
            PostToStoreActivity::class
        ],
     
        'Illuminate\Auth\Events\Logout' => [
            PostToStoreActivity::class
        ],
     
        'Illuminate\Auth\Events\CurrentDeviceLogout' => [
            PostToStoreActivity::class
        ],
     
        'Illuminate\Auth\Events\OtherDeviceLogout' => [
            PostToStoreActivity::class
        ],
     
        'Illuminate\Auth\Events\Lockout' => [
            PostToStoreActivity::class
        ],
     
        'Illuminate\Auth\Events\PasswordReset' => [
            PostToStoreActivity::class
        ],

        ItemWasAddedToCart::class => [
            PostToStoreActivity::class
        ],
        CartItemWasUpdated::class => [
            PostToStoreActivity::class
        ],
        FailedWritingToDbf::class => [
            PostToStoreActivity::class
        ],
        NewDbfEntryCreated::class => [
            PostToStoreActivity::class
        ],
        ExistingDbfEntryUpdated::class => [
            PostToStoreActivity::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
