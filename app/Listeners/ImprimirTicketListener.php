<?php

namespace App\Listeners;

use App\Events\ImprimirTicketEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class ImprimirTicketListener
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
    public function handle(ImprimirTicketEvent $event)
    {

        try {
             //$nombreImpresora = "Bixolon";
            $connector = new NetworkPrintConnector('192.168.0.10',9100);
            //$nombreImpresora = "TM-T202";
           // $connector = new WindowsPrintConnector($nombreImpresora);
            //$connector = new WindowsPrintConnector("smb://192.168.0.189/pos-20");
            $impresora = new Printer($connector);
            $impresora->setJustification(Printer::JUSTIFY_CENTER);
            $impresora->setTextSize(3, 3);
            $impresora->setEmphasis(true);
            $impresora->text("Id caja\n");
            $impresora->text("\n");
            $impresora->text("".$event->caja['id']."\n");
            $impresora->text("\n");
            $impresora->text("\n");
            $impresora->setTextSize(2, 2);
            $impresora->setJustification(Printer::JUSTIFY_LEFT);
            $impresora->text("Ubicacion:". $event->caja['ubicacion']."\n");
            $impresora->text("Rack      :". $event->caja['rack']."\n");
            $impresora->text("Valor     : $10000\n");
            //$impresora->setTextSize(2, 2);
           // $impresora->text("https://parzibyte.me");
            $impresora->feed(10);
            $impresora -> cut();
            $impresora->close();
        } catch (\Throwable $th) {
           dd($th);
        }

    }
}
