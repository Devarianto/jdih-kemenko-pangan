<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cactuar\Admin\Helpers\helper;

use Cactuar\Admin\Models\Menu;
use Cactuar\Admin\Models\Permalink;

class PageController extends Controller
{
    public function home()
    {
        return view('dynamic.home');
    }

    private function find($id=null)
    {
        if(empty($id)) $id = Permalink::active()->uniqid;

        $menu = Menu::translate()->whereIsActive(1)->findOrFail($id);

        return $menu;
    }

    public function getTemplate()
    {
        $menu = $this->find();
        
        $template = helper::dash2camel('get-'.$menu->type);
        if (!method_exists($this,$template))
            abort(404);
        
        return $this->{$template}($menu);
    }

    public function getAbout($menu)
    {
        return view('dynamic.pages.about', compact('menu'));
    }

    public function getAboutSop($menu)
    {
        return view('dynamic.pages.about-sop', compact('menu'));
    }

    public function getAboutVisiMisi($menu)
    {
        return view('dynamic.pages.about-visimisi', compact('menu'));
    }

    public function getAboutStruktur($menu)
    {
        return view('dynamic.pages.about-struktur', compact('menu'));
    }

    public function getAboutContactUs($menu)
    {
        return view('dynamic.pages.about-contactus', compact('menu'));
    }
}
