<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    public function index()
    {
        $shop = Shop::all();
        return view('single-product', compact('shop'));
    }
}
