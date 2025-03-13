<?php

namespace App\View\Composers;

use App\Models\Section;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class FooterComposer
{
    public function __construct(
        private Section $section,
    ) {}


    public function compose(View $view): void
    {
        $sections = Cache::rememberForever(Section::CACHE_KEY_ALL_PAGES, function () {
             return $this->section->with('pages')->orderBy('sort')->get();
        });
        $view->with('sections', $sections);
    }
}
