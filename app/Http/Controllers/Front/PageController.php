<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cactuar\Admin\Helpers\helper;

use Cactuar\Admin\Models\Menu;
use Cactuar\Admin\Models\Permalink;

use App\Models\Gallery;
use App\Models\News;

class PageController extends Controller
{
    public function home()
    {
        $news_first = News::translate()->whereIsActive(1)->orderBy('date', 'desc')->first();
        $news_others = News::translate()->whereIsActive(1)->offset(1)->limit(3)->orderBy('date', 'desc')->get();

        return view('dynamic.home', compact('news_first', 'news_others'));
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

    public function getInformasiGaleri($menu)
    {
        $galleries = Gallery::translate()->whereIsActive(1);

        if (request()->query('filter') == 'image') {
            $galleries = $galleries->where('type', 'image');
        } else if (request()->query('filter') == 'video') {
            $galleries = $galleries->where('type', 'video');
        }

        if (request()->query('sort') == 'latest') {
            $galleries = $galleries->orderBy('date', 'desc');
        } else if (request()->query('sort') == 'oldest') {
            $galleries = $galleries->orderBy('date', 'asc');
        } else {
            $galleries = $galleries->orderBy('date', 'desc');
        }
        
        $galleries = $galleries->paginate(9);
        
        return view('dynamic.pages.informasi-galeri', compact('menu', 'galleries'));
    }

    public function getNews($menu)
    {
        $news = News::translate()->whereIsActive(1);


        if (request()->query('sort') == 'latest') {
            $news = $news->orderBy('date', 'desc');
        } else if (request()->query('sort') == 'oldest') {
            $news = $news->orderBy('date', 'asc');
        } else {
            $news = $news->orderBy('date', 'desc');
        }
        
        $news = $news->paginate(12);
        
        return view('dynamic.pages.documentlainnya-berita', compact('menu', 'news'));
    }

    public function getNewsDetail(){
        $id = Permalink::active()->uniqid;
        $news = News::translate()->whereIsActive(1)->findOrFail($id);
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'news')->first();
        $others = News::translate()->whereIsActive(1)->where('id', '!=', $news->id)->inRandomOrder()->limit(3)->get();
        return view('dynamic.pages.documentlainnya-berita-detail', compact('news', 'menu', 'others'));
    }
}
