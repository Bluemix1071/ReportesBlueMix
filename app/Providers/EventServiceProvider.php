<?php

namespace App\Providers;

use Illuminate\Auth\Events\DescontarStockEvent;
use Illuminate\Auth\Events\ReIn;
use Illuminate\Auth\Listeners\DescontarStockListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        DescontarStockEvent::class => [
            DescontarStockListener::class,
        ],
        ReIngresarStockEvent::class => [
            ReIngresarStockListener::class,
        ],
        ImprimirTicketEvent::class => [
            ImprimirTicketListener::class,
        ],
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
    public function shouldDiscoverEvents()
    {
        return true;
    }
}
