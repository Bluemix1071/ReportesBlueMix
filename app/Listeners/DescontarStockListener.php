<?php

namespace App\Listeners;

use App\Events\DescontarStockEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DescontarStockListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DescontarStockEvent  $event
     * @return void
     */
    public function handle( DescontarStockEvent $event)
    {
        dd("listener descontar stock");
    }
}
