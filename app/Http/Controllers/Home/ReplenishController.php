<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReplenishController extends Controller
{
    //
    public function create(Request $request)
    {
        return view('home.replenish.create');
    }

    public function store(Request $request)
    {
        
    }

}
