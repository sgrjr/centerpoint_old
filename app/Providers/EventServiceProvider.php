<?php

namespace App\Providers;

use \Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use \Illuminate\Support\Facades\Event;

//Events
use \Illuminate\Auth\Events\Registered;
use \App\Events\ItemWasAddedToCart;
use \App\Events\CartItemWasUpdated;
use \App\Events\FailedWritingToDbf;
use \App\Events\NewDbfEntryCreated;
use \App\Events\ExistingDbfEntryUpdated;

use \App\Events\GraphQLAuth\GraphQLLoginAttempted;
use \App\Events\GraphQLAuth\GraphQLUserAuthenticated;
use \App\Events\GraphQLAuth\GraphQLUserAuthenticationFailed;
use \App\Events\GraphQLAuth\GraphQLUserLoggedOut;

use \App\Events\NewMessage;

//Listeners
use \App\Listeners\LogAttemptedLogin;

use \Illuminate\Auth\Listeners\SendEmailVerificationNotification;

use \App\Listeners\PostToStoreActivityUserAuthenticated;
use \App\Listeners\PostToStoreActivityAttemptedLogin;
use \App\Listeners\PostToStoreActivityFailedLogin;
use \App\Listeners\PostToStoreActivityValidatedLogin;
use \App\Listeners\PostToStoreActivityAuthLoggedOut;
use \App\Listeners\PostToStoreActivityAuthLockedOut;
use \App\Listeners\PostToStoreActivityPasswordReset;

use \App\Listeners\PostToStoreActivityItemWasAddedToCart;
use \App\Listeners\PostToStoreActivityCartItemWasUpdated;
use \App\Listeners\PostToStoreActivityFailedWritingToDbf;
use \App\Listeners\PostToStoreActivityNewDbfEntryCreated;
use \App\Listeners\PostToStoreActivityExistingDbfEntryUpdated;

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
        //GraphQLLoginAttempted::class => [
         //   LogAttemptedLogin::class,
            //PostToStoreActivityAttemptedLogin::class
        //],
     
        //GraphQLUserAuthenticated::class => [
            //PostToStoreActivityUserAuthenticated::class
        //],
     
        //GraphQLUserAuthenticationFailed::class => [
           //PostToStoreActivityFailedLogin::class
        //],
     
        \Illuminate\Auth\Events\Validated::class => [
            //PostToStoreActivityValidatedLogin::class
        ],
     
       //GraphQLUserLoggedOut::class => [
            //PostToStoreActivityAuthLoggedOut::class
       // ],
     
        \Illuminate\Auth\Events\Lockout::class => [
            //PostToStoreActivityAuthLockedOut::class
        ],
     
        \Illuminate\Auth\Events\PasswordReset::class => [
            //PostToStoreActivityPasswordReset::class
        ],

        // Cart Related Events
        //ItemWasAddedToCart::class => [
            //PostToStoreActivityItemWasAddedToCart::class
       // ],
        //CartItemWasUpdated::class => [
            //PostToStoreActivityCartItemWasUpdated::class
       // ],
        //FailedWritingToDbf::class => [
            //PostToStoreActivityFailedWritingToDbf::class
       // ],
       // NewDbfEntryCreated::class => [
            //PostToStoreActivityNewDbfEntryCreated::class
      //  ],
      //  ExistingDbfEntryUpdated::class => [
            //PostToStoreActivityExistingDbfEntryUpdated::class
       // ]
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
