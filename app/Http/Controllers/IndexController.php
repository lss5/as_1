<?php

namespace App\Http\Controllers;

use App\Contracts\ImportData\NetworkPrice;
use App\Listing;
use App\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(NetworkPrice $networkPrice)
    {
        $popular = Listing:: //active()
                has('images')
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();

        $newest = Listing:: //active()
                has('images')
                ->orderBy('created_at', 'desc')
                ->limit(4)
                ->get();

        return view('index')->with([
            'popular' => $popular,
            'newest' => $newest,
            'prices' => $networkPrice->getPrices(),
        ]);
    }
}
