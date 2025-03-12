<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Profit;
use App\Services\ImportData\WhatToMine;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profit  $profit
     * @return \Illuminate\Http\Response
     */
    public function show(Profit $profit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profit  $profit
     * @return \Illuminate\Http\Response
     */
    public function edit(Profit $profit)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        $wtm = new WhatToMine();

        foreach ($product->algorithms as $algorithm) {
            $coins = $wtm->getCoins($algorithm->uniq_name);
            foreach ($coins->coins as $coin) {
                $mine = $wtm->getProfit($product, $coin->id);
                if (empty($mine)) {
                    continue;
                }
                $profit = $product->profits()->where('coin_id', $coin->id)->first();
                if ($profit) {
                    $profit->update([
                        'btc_revenue' => preg_replace('/[^0-9\.,]/','', $mine->btc_revenue) * 100000000,
                        'cost' => preg_replace('/[^0-9\.,]/','', $mine->revenue) * 100,
                        'updated_time' => Carbon::createFromTimestamp($mine->timestamp),
                    ]);
                } else {
                    Profit::create([
                        'product_id' => $product->id,
                        'algorithm_id' => $algorithm->id,
                        'coin_id' => $coin->id,
                        'coin_name' => empty($mine->name) ? $mine->tag : $mine->name,
                        'coin_tag' => $mine->tag,
                        'btc_revenue' => preg_replace('/[^0-9\.,]/','', $mine->btc_revenue) * 100000000,
                        'cost' => preg_replace('/[^0-9\.,]/','', $mine->revenue) * 100,
                        'updated_time' => Carbon::createFromTimestamp($mine->timestamp),
                        'mining_time' => '24',
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product '.$product->id.' updated profit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profit  $profit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profit $profit)
    {
        //
    }
}
