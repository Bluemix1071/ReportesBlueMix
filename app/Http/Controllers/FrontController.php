<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;


class FrontController extends Controller
{
    public function detuctDebice(){
        $agent = new Agent;

        $mobileResult = $agent->isMobile();
        if ($mobileResult) {
          $result = 'Yes, This is Mobile.';
        }

        $desktopResult= $agent->isDesktop();
        if ($desktopResult) {
          $result = 'Yes, This is Desktop.';
        }

        $tabletResult= $agent->isTablet();
        if ($tabletResult) {
          $result = 'Yes, This is Desktop.';
        }

        $tabletResult= $agent->isPhone();
        if ($tabletResult) {
          $result = 'Yes, This is Phone.';
        }


        dd($result);
    }
}
