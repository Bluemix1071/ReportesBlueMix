<?php

namespace App\Listeners;

use App\Events\ReIngresarStockEvent;
use App\Modelos\ProductosEnTrancito\Bodeprod;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReIngresarStockListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(ReIngresarStockEvent $event)
    {
        //dd($event->productoEnTrancito['codigo_producto'],$event->productoEnTrancito['cantidad'],"reingresio");

        $sala= Bodeprod::where('bpprod',$event->productoEnTrancito['codigo_producto'])->first();

        //dd($sala);

        $sala->bpsrea = $sala->bpsrea + $event->productoEnTrancito['cantidad'];

        $sala->save();
    }
}
