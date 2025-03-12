<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        return view('admin.status.index', ['statuses' => Status::all()]);
    }

    public function create()
    {
        return view('admin.status.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'uniq_name' => ['required', 'string', 'unique:statuses,uniq_name'],
        ]);

        $status = Status::create($validated);

        return redirect()->route('admin.statuses.index')->with('success', 'Status '.$status->name.' created');
    }

    public function edit(Status $status)
    {
        return view('admin.status.edit', ['status' => $status]);
    }

    public function update(Request $request, Status $status)
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'uniq_name' => ['required', 'string', 'unique:statuses,uniq_name,'.$status->id],
        ]);

        $status->update($validated);

        return redirect()->route('admin.statuses.index')->with('success', 'Status '.$status->name.' updated');
    }

    public function destroy(Status $status)
    {
        //
    }
}
