<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Page;
use App\Section;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('admin.page.index')->with([
            'pages' => $pages,
        ]);
    }

    public function create()
    {
        return view('admin.page.create')->with([
            'sections' => Section::orderBy('sort')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'list_name' => ['required', 'string'],
            'uniq_name' => ['required', 'string', 'unique:pages'],
            'content' => ['required', 'string'],
            'section_id' => ['required', 'integer'],
        ]);

        $page = Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page '.$page->name.' created');
    }

    public function edit(Page $page)
    {
        return view('admin.page.edit')->with([
            'page' => $page,
            'sections' => Section::orderBy('sort')->get(),
        ]);
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'list_name' => ['required', 'string'],
            'uniq_name' => ['required', 'string', 'unique:pages,uniq_name,'.$page->id],
            'content' => ['required', 'string'],
            'section_id' => ['required', 'integer'],
        ]);

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page '.$page->name.' update');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted');
    }
}
