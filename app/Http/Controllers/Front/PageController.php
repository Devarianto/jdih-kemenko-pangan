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
use App\Models\Infografis;
use App\Models\KamusHukum;
use App\Models\Rating;

use DB;

class PageController extends Controller
{
    public function home()
    {
        $home = Menu::translate()->firstOrFail();

        $rule_types = RuleType::whereIsActive(1)->get();
        $rule_themes = RuleTheme::whereIsActive(1)->get();
        $year_peraturan = Document::select('year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->groupBy('year')
            ->get();

        $news_first = News::translate()->whereIsActive(1)->orderBy('date', 'desc')->first();
        $news_others = News::translate()->whereIsActive(1)->offset(1)->limit(3)->orderBy('date', 'desc')->get();

        $gallery_image = Gallery::translate()->whereIsActive(1)->where('type', 'image')->orderBy('date', 'desc')->first();
        $gallery_video = Gallery::translate()->whereIsActive(1)->where('type', 'video')->orderBy('date', 'desc')->first();

        $newest_documents = Document::translate()->whereIsActive(1)->orderBy('created_at', 'desc')->limit(5)->get();
        $popular_documents = Document::translate()->whereIsActive(1)->orderBy('view_count', 'desc')->limit(4)->get();

        $menus = [];
        //Monografi
        $document_monografi = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::MONOGRAFI)
            ->orderBy('created_at', 'desc');
        $monografi_count = $document_monografi->count();
        $document_monografi = $document_monografi->limit(4)
            ->get();
        $menus['monografi'] = Menu::fe()->whereIsActive(1)->where('type', 'monografi-hukum')->first();

        // Peraturan
        $document_peraturan = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->orderBy('created_at', 'desc');
        $peraturan_count = $document_peraturan->count();
        $document_peraturan = $document_peraturan->limit(4)
            ->get();
        $menus['peraturan'] = Menu::fe()->whereIsActive(1)->where('type', 'peraturan-hukum')->first();

        // Putusan
        $document_putusan = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::PUTUSAN)
            ->orderBy('created_at', 'desc');
        $putusan_count = $document_putusan->count();
        $document_putusan = $document_putusan->limit(4)
            ->get();
        $menus['putusan'] = Menu::fe()->whereIsActive(1)->where('type', 'putusan-hukum')->first();

        // Jurnal
        $document_jurnal = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::JURNAL)
            ->orderBy('created_at', 'desc');
        $jurnal_count = $document_jurnal->count();
        $document_jurnal = $document_jurnal->limit(4)
            ->get();
        $menus['jurnal'] = Menu::fe()->whereIsActive(1)->where('type', 'jurnal-hukum')->first();

        // Kliping
        $document_kliping = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::KLIPING)
            ->orderBy('created_at', 'desc');
        $kliping_count = $document_kliping->count();
        $document_kliping = $document_kliping->limit(4)
            ->get();
        $menus['kliping'] = Menu::fe()->whereIsActive(1)->where('type', 'kliping-hukum')->first();

        // Majalah
        $document_majalah = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::MAJALAH)
            ->orderBy('created_at', 'desc');
        $majalah_count = $document_majalah->count();
        $document_majalah = $document_majalah->limit(4)
            ->get();
        $menus['majalah'] = Menu::fe()->whereIsActive(1)->where('type', 'majalah-hukum')->first();

        // Naskah
        $document_naskah = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::NASKAH)
            ->orderBy('created_at', 'desc');
        $naskah_count = $document_naskah->count();
        $document_naskah = $document_naskah->limit(4)
            ->get();
        $menus['naskah'] = Menu::fe()->whereIsActive(1)->where('type', 'naskah-hukum')->first();


        $years = Document::select('year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->groupBy('year')
            ->get();

        $get_chart = $this->getChartStatistic($years);

        $menu_statistic = Menu::fe()->whereIsActive(1)->where('type', 'about-statistik')->first();

        // Rating
        $total_rating = Rating::count();
        $average = Rating::avg('rating');
        $avg_rating = round($average, 1);

        $rating = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        ];

        $get_rating = Rating::select('rating', DB::raw('count(rating) as count_rating'))->groupBy('rating')->pluck('count_rating', 'rating')->toArray();

        foreach ($rating as $key => $data) {
            if (isset($get_rating[$key])) {
                $rating[$key] = $get_rating[$key];
            }
        }

        $rating = json_encode($rating);

        return view('dynamic.home', compact(
            'news_first', 'news_others', 'newest_documents', 
            'document_monografi', 'monografi_count', 
            'document_peraturan', 'peraturan_count',
            'document_putusan', 'putusan_count', 
            'document_jurnal', 'jurnal_count', 
            'document_majalah', 'majalah_count', 
            'document_kliping', 'kliping_count', 
            'document_naskah', 'naskah_count', 
            'menus', 'popular_documents', 
            'gallery_image', 'gallery_video', 
            'get_chart', 'menu_statistic',
            'total_rating', 'avg_rating', 'rating', 'home', 'rule_types', 'rule_themes', 'year_peraturan'));
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

    public function getFAQ($menu)
    {
        return view('dynamic.pages.faq', compact('menu'));
    }

    public function getInformasiRancangan($menu)
    {
        return view('dynamic.pages.informasi-rancangan', compact('menu'));
    }

    public function getAboutStatistik($menu)
    {
        $rule_types = null;

        if (request()->query('year')) {
            $rule_types = RuleType::withCount([
                'documents' => function($query) {
                    $query->where('master_document_id', Document::PERATURAN)->where('year', request()->query('year'));
                }
            ])->whereIsActive(1)->get();
        } else {
            $rule_types = RuleType::withCount([
                'documents' => function($query) {
                    $query->where('master_document_id', Document::PERATURAN);
                }
            ])->whereIsActive(1)->get();
        }
        
        $years = Document::select('year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->groupBy('year')
            ->get();
        
        $colors = [];
        $arr_rule_label = [];
        $arr_rule_count = [];

        foreach ($rule_types as $data) {
            $colors[] = $data->chart_color;
            $arr_rule_label[] = $data->label;
            $arr_rule_count[] = $data->documents_count;
        }

        $get_chart = $this->getChartStatistic($years);

        return view('dynamic.pages.about-statistik', compact('menu', 'rule_types', 'years', 'colors', 'arr_rule_label', 'arr_rule_count', 'get_chart'));
    }

    public function getChartStatistic($years)
    {
        $year_berlaku = Document::select('year', DB::raw('count(year) as count_year'))
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->where('status_berlaku', 1)
            ->groupBy('year')
            ->pluck('count_year', 'year')
            ->toArray();

        $year_tidak_berlaku = Document::select('year', DB::raw('count(year) as count_year'))
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->where('status_berlaku', 0)
            ->groupBy('year')
            ->pluck('count_year', 'year')
            ->toArray();

        $arr_year_berlaku = [
            'year' => [],
            'data' => [],
        ];
        $arr_year_tidak_berlaku = [
            'year' => [],
            'data' => [],
        ];

        foreach ($years as $data) {
            $arr_year_berlaku['year'][] = $data->year;
            $arr_year_berlaku['data'][] = isset($year_berlaku[$data->year]) ? $year_berlaku[$data->year] : 0;
        }

        foreach ($years as $data) {
            $arr_year_tidak_berlaku['year'][] = $data->year;
            $arr_year_tidak_berlaku['data'][] = isset($year_tidak_berlaku[$data->year]) ? $year_tidak_berlaku[$data->year] : 0;
        }

        return ['berlaku' => $arr_year_berlaku, 'tidak-berlaku' => $arr_year_tidak_berlaku];
    }

    public function getInformasiGaleri($menu)
    {
        $galleries = Gallery::translate()->whereIsActive(1);

        if (request()->query('filter') == 'image') {
            $galleries = $galleries->where('type', 'image');
        } else if (request()->query('filter') == 'video') {
            $galleries = $galleries->where('type', 'video');
        }
        
        if (request()->query('sort') == 'oldest') {
            $galleries = $galleries->orderBy('date', 'asc');
        } else {
            $galleries = $galleries->orderBy('date', 'desc');
        }
        
        $galleries = $galleries->paginate(9);
        
        return view('dynamic.pages.informasi-galeri', compact('menu', 'galleries'));
    }

    public function getInformasiInfografis($menu)
    {
        $infografis = Infografis::translate()->whereIsActive(1);

        if (request()->query('sort') == 'latest') {
            $infografis = $infografis->orderBy('date', 'desc');
        } else if (request()->query('sort') == 'oldest') {
            $infografis = $infografis->orderBy('date', 'asc');
        } else {
            $infografis = $infografis->orderBy('date', 'desc');
        }
        
        $infografis = $infografis->paginate(12);
        
        return view('dynamic.pages.documentlainnya-infografis', compact('menu', 'infografis'));
    }

    public function getInformasiInfografisDetail()
    {
        $id = Permalink::active()->uniqid;
        $infografis = Infografis::translate()->whereIsActive(1)->findOrFail($id);
        $infografis->view_count += 1;
        $infografis->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'informasi-infografis')->first();
        $others = Infografis::translate()->whereIsActive(1)->where('id', '!=', $news->id)
            ->inRandomOrder()
            ->limit(3)
            ->get()
            ->sortByDesc('date')
            ->values();
            
        return view('dynamic.pages.documentlainnya-infografis-detail', compact('infografis', 'menu', 'others'));
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
        
        $news = $news->paginate(9);
        
        return view('dynamic.pages.documentlainnya-berita', compact('menu', 'news'));
    }

    public function getNewsDetail()
    {
        $id = Permalink::active()->uniqid;
        $news = News::translate()->whereIsActive(1)->findOrFail($id);
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'news')->first();
        $others = News::translate()->whereIsActive(1)->where('id', '!=', $news->id)
            ->inRandomOrder()
            ->limit(3)
            ->get()
            ->sortByDesc('date')
            ->values();
            
        return view('dynamic.pages.documentlainnya-berita-detail', compact('news', 'menu', 'others'));
    }

    public function getInformasiKamusHukum($menu)
    {
        $kamus = KamusHukum::translate()->whereIsActive(1);

        if (request()->query('option') && request()->query('option') != 'all') {
            $kamus = $kamus->where('title', 'like', request()->query('option').'%');
        }

        if (request()->query('search')) {
            $kamus = $kamus->where('title', 'like', '%'.request()->query('search').'%');
        }
        
        $kamus = $kamus->paginate(6);
        
        return view('dynamic.pages.documentlainnya-kamus-hukum', compact('menu', 'kamus'));
    }

    public function getInformasiKamusHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $kamus = KamusHukum::translate()->whereIsActive(1)->findOrFail($id);
        $kamus->view_count += 1;
        $kamus->save();

        $menu = Menu::fe()->whereIsActive(1)->where('type', 'informasi-kamus-hukum')->first();
        $others = KamusHukum::translate()->whereIsActive(1)->where('id', '!=', $kamus->id)->inRandomOrder()->limit(3)->get();
        return view('dynamic.pages.documentlainnya-kamus-hukum-detail', compact('kamus', 'menu', 'others'));
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

    public function getJurnalHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::JURNAL);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->where('tahun_terbit', request()->query('year'));
        }
        
        $documents = $documents->orderBy('id', 'desc')->paginate(12);

        $years = Document::select('tahun_terbit')
            ->whereIsActive(1)
            ->where('master_document_id', Document::JURNAL)
            ->groupBy('tahun_terbit')
            ->get();
        
        return view('dynamic.pages.document-jurnal', compact('menu', 'documents', 'years'));
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

    public function getPutusanHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::PUTUSAN);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->whereYear('tanggal_dibacakan', request()->query('year'));
        }

        if (request()->query('sort') == 'oldest') {
            $documents = $documents->orderBy('id', 'asc');
        } else {
            $documents = $documents->orderBy('id', 'desc');
        }
        
        $documents = $documents->orderBy('id', 'desc')->paginate(9);

        $years = Document::selectRaw('YEAR(tanggal_dibacakan) as year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PUTUSAN)
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        return view('dynamic.pages.document-putusan', compact('menu', 'documents', 'years'));
    }

    public function getMonografiHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::MONOGRAFI);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->where('tahun_terbit', request()->query('year'));
        }
        
        $documents = $documents->orderBy('id', 'desc')->paginate(12);

        $years = Document::select('tahun_terbit')
            ->whereIsActive(1)
            ->where('master_document_id', Document::MONOGRAFI)
            ->groupBy('tahun_terbit')
            ->get();
        
        return view('dynamic.pages.document-monografi', compact('menu', 'documents', 'years'));
    }

    public function getNaskahHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::NASKAH);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->whereYear('tanggal_berlaku', request()->query('year'));
        }
        
        $documents = $documents->orderBy('id', 'desc')->paginate(12);

        $years = Document::selectRaw('YEAR(tanggal_berlaku) as year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::NASKAH)
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        return view('dynamic.pages.document-naskah', compact('menu', 'documents', 'years'));
    }
}
