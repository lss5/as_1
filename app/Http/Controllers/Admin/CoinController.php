<?php

namespace App\Http\Controllers\Admin;

use App\Coin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    public function index()
    {
        return view('admin.coins.index', ['coins' => Coin::orderBy('sort')->get()]);
    }

    public function create()
    {
        return view('admin.coins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'short_name' => ['required', 'string'],
            'sort' => ['required', 'integer'],
        ]);

        $coin = Coin::create($validated);

        return redirect()->route('admin.coin.index')->with('success', 'Coin '.$coin->name.' created');
    }

    public function edit(Coin $coin)
    {
        return view('admin.coins.edit', ['coin' => $coin]);
    }

    public function update(Request $request, Coin $coin)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'short_name' => ['required', 'string'],
            'sort' => ['required', 'integer'],
        ]);

        $coin->update($validated);

        return redirect()->route('admin.coin.index')->with('success', 'Coin '.$coin->name.' updated');
    }

    public function destroy(Coin $coin)
    {
        $coin->delete();

        return redirect()->route('admin.coin.index')->with('success', 'Coin '.$coin->name.' deleted');
    }
}
