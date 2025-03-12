<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use Illuminate\Http\Request;

class CoinController extends Controller
{
    public function index()
    {
        return view('admin.coin.index', ['coins' => Coin::orderBy('sort')->get()]);
    }

    public function create()
    {
        return view('admin.coin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'short_name' => ['required', 'string'],
            'sort' => ['required', 'integer'],
        ]);

        $coin = Coin::create($validated);

        return redirect()->route('admin.coins.index')->with('success', 'Coin '.$coin->name.' created');
    }

    public function edit(Coin $coin)
    {
        return view('admin.coin.edit', ['coin' => $coin]);
    }

    public function update(Request $request, Coin $coin)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'short_name' => ['required', 'string'],
            'sort' => ['required', 'integer'],
        ]);

        $coin->update($validated);

        return redirect()->route('admin.coins.index')->with('success', 'Coin '.$coin->name.' updated');
    }

    public function destroy(Coin $coin)
    {
        $coin->delete();

        return redirect()->route('admin.coins.index')->with('success', 'Coin '.$coin->name.' deleted');
    }
}
