<?php

namespace App\Http\Controllers\Admin;

use App\Algorithm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AlgorithmController extends Controller
{
    public function index()
    {
        return view('admin.algorithms.index', ['algorithms' => Algorithm::orderBy('sort')->get()]);
    }

    public function create()
    {
        return view('admin.algorithms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'sort' => ['required', 'integer'],
        ]);

        $algorithm = Algorithm::create($validated);

        return redirect()->route('admin.algorithm.index')->with('success', 'Algorithm '.$algorithm->name.' created');
    }

    public function edit(Algorithm $algorithm)
    {
        return view('admin.algorithms.edit', ['algorithm' => $algorithm]);
    }

    public function update(Request $request, Algorithm $algorithm)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'sort' => ['required', 'integer'],
        ]);

        $algorithm->update($validated);

        return redirect()->route('admin.algorithm.index')->with('success', 'Algorithm '.$algorithm->name.' updated');
    }

    public function destroy(Algorithm $algorithm)
    {
        $algorithm->delete();

        return redirect()->route('admin.algorithm.index')->with('success', 'Algorithm '.$algorithm->name.' deleted');
    }
}
