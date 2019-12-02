<?php

namespace App\Http\Controllers\GiftCard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GiftCardController extends Controller
{
 

    public function index(){

        return view('giftCard.index');

    }
}
