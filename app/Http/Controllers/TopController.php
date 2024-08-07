<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TopController extends Controller
{
    public function __construct()
    {
    }


    /**
     * Render index page
     */
    public function index(Request $request)
    {
        return view('screens.top.index');
    }
}
