<?php

namespace App\Listeners;

use App\Events\DescontarStockEvent;
use App\Modelos\ProductosEnTrancito\Bodeprod;
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
        //dd($event->productoEnTrancito);

        $sala= Bodeprod::where('bpprod',$event->productoEnTrancito['codigo_producto'])->first();


        $sala->bpsrea = $sala->bpsrea - $event->productoEnTrancito['cantidad'];

        $sala->save();
    }
}
