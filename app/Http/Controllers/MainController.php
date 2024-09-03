<?php

namespace App\Http\Controllers;

use App\Contracts\ImportData\NetworkPrice;
use App\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(NetworkPrice $networkPrice)
    {
        $networkPrice->setPrices();

        $popular = Product::active()
                ->has('images')
                ->orderBy('views', 'desc')
                ->limit(4)
                ->get();

        $newest = Product::active()
                ->has('images')
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();

        return view('main')->with([
            'popular' => $popular,
            'newest' => $newest,
            'prices' => $networkPrice->prices,
        ]);
    }
}
