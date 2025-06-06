<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DateTime;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function smalldateToHex(string $fecha): string {
        // Asume siempre la hora 00:00
        $dt = new DateTime($fecha . ' 00:00');
        $base = new DateTime('1900-01-01 00:00');

        // Días desde la base (1900-01-01)
        $dias = (int)$base->diff($dt)->format('%a');

        // Minutos = 0 porque es 00:00
        $minutos = 0;

        // Convertir a binario (2 bytes minutos, 2 bytes días), little-endian
        $hex = unpack('H*', pack('v2', $minutos, $dias))[1];

        return '0x' . strtoupper($hex);
    }
}
