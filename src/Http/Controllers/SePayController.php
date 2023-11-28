<?php

namespace SePay\SePay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SePayController extends Controller
{
    public function webhook(Request $request)
    {
        logger($request->all());
        return response()->noContent();
    }
}
