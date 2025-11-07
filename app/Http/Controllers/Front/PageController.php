<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cactuar\Admin\Helpers\helper;

use Cactuar\Admin\Models\Menu;
use Cactuar\Admin\Models\Permalink;

use App\Models\Gallery;
use App\Models\News;
use App\Models\Document;
use App\Models\RuleType;
use App\Models\RuleTheme;

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

    public function getNewsDetail()
    {
        $id = Permalink::active()->uniqid;
        $news = News::translate()->whereIsActive(1)->findOrFail($id);
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'news')->first();
        $others = News::translate()->whereIsActive(1)->where('id', '!=', $news->id)->inRandomOrder()->limit(3)->get();
        return view('dynamic.pages.documentlainnya-berita-detail', compact('news', 'menu', 'others'));
    }

    public function getPeraturanHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::PERATURAN);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('rule_type')) {
            $documents = $documents->where('rule_type_id', request()->query('rule_type'));
        }

        if (request()->query('theme')) {
            $documents = $documents->where('rule_theme_id', request()->query('theme'));
        }

        if (request()->query('year')) {
            $documents = $documents->where('year', request()->query('year'));
        }
        
        $documents = $documents->orderBy('id', 'desc')->paginate(9);

        $rule_types = RuleType::whereIsActive(1)->get();
        $rule_themes = RuleTheme::whereIsActive(1)->get();
        $years = Document::select('year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->groupBy('year')
            ->get();
        
        return view('dynamic.pages.document-peraturan', compact('menu', 'documents', 'rule_types', 'rule_themes', 'years'));
    }

    public function getPeraturanHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::PERATURAN)->where('id', $id)->firstOrFail();
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'peraturan-hukum')->first();

        return view('dynamic.pages.document-peraturan-detail', compact('document', 'menu'));
    }

    public function getJurnalHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::JURNAL);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->where('tahun_terbit', request()->query('year'));
        }
        
        $documents = $documents->orderBy('id', 'desc')->paginate(9);

        $years = Document::select('tahun_terbit')
            ->whereIsActive(1)
            ->where('master_document_id', Document::JURNAL)
            ->groupBy('tahun_terbit')
            ->get();
        
        return view('dynamic.pages.document-jurnal', compact('menu', 'documents', 'years'));
    }

    public function getJurnalHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::JURNAL)->where('id', $id)->firstOrFail();
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'jurnal-hukum')->first();

        return view('dynamic.pages.document-jurnal-detail', compact('document', 'menu'));
    }

    public function getKlipingHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::KLIPING);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->where('tahun_terbit', request()->query('year'));
        }
        
        $documents = $documents->orderBy('id', 'desc')->paginate(9);

        $years = Document::select('tahun_terbit')
            ->whereIsActive(1)
            ->where('master_document_id', Document::KLIPING)
            ->groupBy('tahun_terbit')
            ->get();
        
        return view('dynamic.pages.document-kliping', compact('menu', 'documents', 'years'));
    }

    public function getKlipingHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::KLIPING)->where('id', $id)->firstOrFail();
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'kliping-hukum')->first();

        return view('dynamic.pages.document-kliping-detail', compact('document', 'menu'));
    }

    public function getMajalahHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::MAJALAH);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->where('tahun_terbit', request()->query('year'));
        }
        
        $documents = $documents->orderBy('id', 'desc')->paginate(9);

        $years = Document::select('tahun_terbit')
            ->whereIsActive(1)
            ->where('master_document_id', Document::MAJALAH)
            ->groupBy('tahun_terbit')
            ->get();
        
        return view('dynamic.pages.document-article', compact('menu', 'documents', 'years'));
    }

    public function getMajalahHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::MAJALAH)->where('id', $id)->firstOrFail();
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'majalah-hukum')->first();

        return view('dynamic.pages.document-article-detail', compact('document', 'menu'));
    }

    public function getPutusanHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::PUTUSAN);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->whereYear('tanggal_peradilan', request()->query('year'));
        }

        if (request()->query('sort') == 'oldest') {
            $documents = $documents->orderBy('tanggal_peradilan', 'asc');
        } else {
            $documents = $documents->orderBy('tanggal_peradilan', 'desc');
        }
        
        $documents = $documents->orderBy('id', 'desc')->paginate(9);

        $years = Document::selectRaw('YEAR(tanggal_peradilan) as year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PUTUSAN)
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        return view('dynamic.pages.document-putusan', compact('menu', 'documents', 'years'));
    }

    public function getPutusanHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::PUTUSAN)->where('id', $id)->firstOrFail();
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'putusan-hukum')->first();

        return view('dynamic.pages.document-putusan-detail', compact('document', 'menu'));
    }
}
