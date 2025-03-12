<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    public function show(Page $page)
    {
        return view('page.show')->with(['page' => $page]);
    }
}
