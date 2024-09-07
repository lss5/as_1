<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::orderBy('sort')->get();
        return view('admin.section.index')->with([
            'sections' => $sections,
        ]);
    }

    public function create()
    {
        return view('admin.section.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'uniq_name' => ['required', 'string', 'unique:sections'],
            'sort' => ['required', 'integer'],
        ]);

        $section = Section::create($data);

        return redirect()->route('admin.sections.index')->with('success', 'Section '.$section->name.' created');
    }

    public function edit(Section $section)
    {
        return view('admin.section.edit')->with(['section' => $section]);
    }

    public function update(Request $request, Section $section)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'uniq_name' => ['required', 'string', 'unique:sections,uniq_name,'.$section->id],
            'sort' => ['required', 'integer'],
        ]);

        $section->update($data);

        return redirect()->route('admin.sections.index')->with('success', 'Section '.$section->name.' updated');
    }

    public function destroy(Section $section)
    {
        $section->delete();

        return redirect()->route('admin.sections.index')->with('success', 'Section '.$section->name.' deleted');
    }
}
