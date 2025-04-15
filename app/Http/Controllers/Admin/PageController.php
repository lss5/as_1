<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('section_id')->orderBy('sort')->get();
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
            'section_id' => ['required', 'integer', 'exists:sections,id'],
            'sort' => ['required', 'integer'],
        ]);

        $page = Page::create($data);

        Cache::forget(Section::CACHE_KEY_ALL_PAGES);

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
            'sort' => ['required', 'integer'],
        ]);

        $page->update($data);

        Cache::forget(Section::CACHE_KEY_ALL_PAGES);

        return redirect()->route('admin.pages.index')->with('success', 'Page '.$page->name.' update');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted');
    }

    public function image_upload(Request $request)
    {
        $link = $request->file('file')->store('pages', 'public');
        return json_encode(array('location' => asset('storage/'.$link)));
    }
}
