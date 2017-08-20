<?php

declare(strict_types=1);

namespace Rinvex\Pages\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PagesController extends Controller
{
    public function __invoke(Request $request)
    {
        $page = app('rinvex.pages.page')->where('uri', $request->route()->uri())->where('domain', $request->route()->domain())->first();

        return view($page->view, compact('page'));
    }
}
