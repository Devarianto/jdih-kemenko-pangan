<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cactuar\Admin\Helpers\helper;
use Cactuar\Admin\Helpers\og;

use Cactuar\Admin\Models\Menu;
use Cactuar\Admin\Models\Permalink;
use Cactuar\Admin\Models\Conf;

use App\Models\Gallery;
use App\Models\News;
use App\Models\Document;
use App\Models\RuleType;
use App\Models\RuleTheme;
use App\Models\Infografis;
use App\Models\KamusHukum;
use App\Models\Rating;

use DB;
use Carbon\Carbon;

class PageController extends Controller
{
    public function home()
    {
        $home = Menu::translate()->firstOrFail();

        $rule_types = RuleType::whereIsActive(1)->get();
        $rule_themes = RuleTheme::whereIsActive(1)->orderBy('sort_id')->get();
        $year_peraturan = Document::select('year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->orderBy('year', 'desc')
            ->groupBy('year')
            ->get();

        $news_first = News::translate()->whereIsActive(1)->orderBy('date', 'desc')->first();
        $news_others = News::translate()->whereIsActive(1)->offset(1)->limit(3)->orderBy('date', 'desc')->get();

        $gallery_image = Gallery::translate()->whereIsActive(1)->where('type', 'image')->orderBy('date', 'desc')->first();
        $gallery_video = Gallery::translate()->whereIsActive(1)->where('type', 'video')->orderBy('date', 'desc')->first();

        $newest_documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::PERATURAN)->orderBy('tanggal_penetapan', 'desc')->limit(5)->get();
        $popular_documents = Document::translate()->whereIsActive(1)->orderBy('view_count', 'desc')->limit(4)->get();

        $menus = [];
        //Monografi
        $document_monografi = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::MONOGRAFI)
            ->orderBy('tahun_terbit', 'desc')->orderBy('created_at','desc');
        $monografi_count = $document_monografi->count();
        $document_monografi = $document_monografi->limit(4)
            ->get();
        $menus['monografi'] = Menu::fe()->whereIsActive(1)->where('type', 'monografi-hukum')->first();

        // Peraturan
        $document_peraturan = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->orderBy('tanggal_penetapan', 'desc');
        $peraturan_count = $document_peraturan->count();
        $document_peraturan = $document_peraturan->limit(4)
            ->get();
        $menus['peraturan'] = Menu::fe()->whereIsActive(1)->where('type', 'peraturan-hukum')->first();

        // Putusan
        $document_putusan = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::PUTUSAN)
            ->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        $putusan_count = $document_putusan->count();
        $document_putusan = $document_putusan->limit(4)
            ->get();
        $menus['putusan'] = Menu::fe()->whereIsActive(1)->where('type', 'putusan-hukum')->first();

        // Jurnal
        $document_jurnal = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::JURNAL)
            ->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        $jurnal_count = $document_jurnal->count();
        $document_jurnal = $document_jurnal->limit(4)
            ->get();
        $menus['jurnal'] = Menu::fe()->whereIsActive(1)->where('type', 'jurnal-hukum')->first();

        // Kliping
        $document_kliping = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::KLIPING)
            ->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        $kliping_count = $document_kliping->count();
        $document_kliping = $document_kliping->limit(4)
            ->get();
        $menus['kliping'] = Menu::fe()->whereIsActive(1)->where('type', 'kliping-hukum')->first();

        // Majalah
        $document_majalah = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::MAJALAH)
            ->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        $majalah_count = $document_majalah->count();
        $document_majalah = $document_majalah->limit(4)
            ->get();
        $menus['majalah'] = Menu::fe()->whereIsActive(1)->where('type', 'majalah-hukum')->first();

        // Naskah
        $document_naskah = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::NASKAH)
            ->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
        $naskah_count = $document_naskah->count();
        $document_naskah = $document_naskah->limit(4)
            ->get();
        $menus['naskah'] = Menu::fe()->whereIsActive(1)->where('type', 'naskah-hukum')->first();


        $now_year = (int) Carbon::now()->format('Y');
        $back_year = (int) Carbon::now()->subYear(4)->format('Y');
        $years = Document::select('year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->where('year', '<=', $now_year)
            ->where('year', '>=', $back_year)
            ->groupBy('year')
            ->orderBy("year", 'desc')
            ->get();

        $arr_years = [];
        for ($i=0; $i < 5; $i++) { 
            $arr_years[] = $now_year;
            $now_year -= 1;
        }

        sort($arr_years);

        $get_chart = $this->getChartStatistic($arr_years);

        $menu_statistic = Menu::fe()->whereIsActive(1)->where('type', 'about-statistik')->first();

        // Rating
        $total_rating = Rating::whereIsActive(1)->count();
        $average = Rating::whereIsActive(1)->avg('rating');
        $avg_rating = round($average, 1);

        $rating = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        ];

        $get_rating = Rating::select('rating', DB::raw('count(rating) as count_rating'))->whereIsActive(1)->groupBy('rating')->pluck('count_rating', 'rating')->toArray();
        
        foreach ($rating as $key => $data) {
            if (isset($get_rating[$key])) {
                $rating[$key] = $get_rating[$key];
            }
        }
        
        $rating = json_encode($rating);

        $popup = Conf::initial('popup-page');
        
        $artikel_count = $jurnal_count + $majalah_count;
        $document_rancangan = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::RANCANGAN_PUU);
        $rancangan_count = $document_rancangan->count();
        $menus['rancangan'] = Menu::fe()->whereIsActive(1)->where('type', 'rancangan-puu')->first();

        return view('dynamic.home', compact(
            'news_first', 'news_others', 'newest_documents', 
            'document_monografi', 'monografi_count', 
            'document_peraturan', 'peraturan_count',
            'document_putusan', 'putusan_count', 
            'document_jurnal', 'jurnal_count', 
            'document_majalah', 'majalah_count', 
            'document_kliping', 'kliping_count', 
            'document_naskah', 'naskah_count', 
            'artikel_count', 'rancangan_count',
            'menus', 'popular_documents', 
            'gallery_image', 'gallery_video', 
            'get_chart', 'menu_statistic',
            'total_rating', 'avg_rating', 'rating', 'home', 'rule_types', 'rule_themes', 'year_peraturan', 'popup'));
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
        $selectedYear = request()->query('year');
        $selectedRuleTypeId = request()->query('rule_type_id');

        $stats = StatisticController::getStatisticsData($selectedYear, $selectedRuleTypeId);
        $matrix = StatisticController::getCrossTabMatrix($selectedYear, $selectedRuleTypeId);

        // Populate backward-compatible variables for existing and enhanced blade templates
        $rule_types = collect($stats['by_type'])->map(function($item) {
            return (object) [
                'id' => $item['id'],
                'label' => $item['label'],
                'documents_count' => $item['count'],
                'chart_color' => $item['color'],
                'percentage' => $item['percentage'],
            ];
        });

        $years = collect($stats['filters']['available_years'])->map(function($y) {
            return (object) ['year' => $y];
        });

        $colors = collect($stats['by_type'])->pluck('color')->toArray();
        $arr_rule_label = collect($stats['by_type'])->pluck('label')->toArray();
        $arr_rule_count = collect($stats['by_type'])->pluck('count')->toArray();

        $get_chart = [
            'berlaku' => [
                'year' => collect($stats['by_year'])->pluck('year')->toArray(),
                'data' => collect($stats['by_year'])->pluck('berlaku_count')->toArray(),
            ],
            'tidak-berlaku' => [
                'year' => collect($stats['by_year'])->pluck('year')->toArray(),
                'data' => collect($stats['by_year'])->pluck('tidak_berlaku_count')->toArray(),
            ],
        ];

        return view('dynamic.pages.about-statistik', compact(
            'menu', 'rule_types', 'years', 'colors', 'arr_rule_label', 'arr_rule_count', 'get_chart', 'stats', 'matrix'
        ));
    }

    public function getChartStatistic($years)
    {
        $now_year = (int) Carbon::now()->format('Y');
        $back_year = (int) Carbon::now()->subYear(4)->format('Y');
        
        $year_berlaku = Document::select('year', DB::raw('count(year) as count_year'))
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->where('status_berlaku', 1)
            ->where('year', '<=', $now_year)
            ->where('year', '>=', $back_year)
            ->groupBy('year')
            ->pluck('count_year', 'year')
            ->toArray();

        $year_tidak_berlaku = Document::select('year', DB::raw('count(year) as count_year'))
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->where('status_berlaku', 0)
            ->where('year', '<=', $now_year)
            ->where('year', '>=', $back_year)
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
            $arr_year_berlaku['year'][] = $data;
            $arr_year_berlaku['data'][] = isset($year_berlaku[$data]) ? $year_berlaku[$data] : 0;
        }

        foreach ($years as $data) {
            $arr_year_tidak_berlaku['year'][] = $data;
            $arr_year_tidak_berlaku['data'][] = isset($year_tidak_berlaku[$data]) ? $year_tidak_berlaku[$data] : 0;
        }

        return ['berlaku' => $arr_year_berlaku, 'tidak-berlaku' => $arr_year_tidak_berlaku];
    }

    public function getInformasiGaleri($menu)
    {
        $galleries = Gallery::translate()->whereIsActive(1);

        $filter = request()->query('filter', 'all');
        if ($filter == 'image') {
            $galleries = $galleries->where('type', 'image');
        } else if ($filter == 'video') {
            $galleries = $galleries->where('type', 'video')
                ->whereHas('classifications', function($q) {
                    $q->where('code', 'galeri');
                });
        } else {
            // 'all': images OR videos that have the 'galeri' classification
            $galleries = $galleries->where(function($q) {
                $q->where('type', 'image')
                  ->orWhere(function($sub) {
                      $sub->where('type', 'video')
                          ->whereHas('classifications', function($c) {
                              $c->where('code', 'galeri');
                          });
                  });
            });
        }
        
        if (request()->query('sort') == 'oldest') {
            $galleries = $galleries->orderBy('date', 'asc');
        } else {
            $galleries = $galleries->orderBy('sort_id', 'asc')->orderBy('date', 'desc');
        }
        
        $galleries = $galleries->paginate(9);
        
        return view('dynamic.pages.informasi-galeri', compact('menu', 'galleries'));
    }

    public function getInformasiInfografis($menu)
    {
        try {
            $hasTataNaskah = \Cactuar\Admin\Models\Permalink::where('module', 'information-infografis')
                ->where('permalink', 'tata-naskah-dinas-kementerian-koordinator-bidang-pangan')
                ->exists();
            if (!$hasTataNaskah) {
                $existingRow = \DB::table('infografis')->where('date', '2026-08-26')->where('thumbnail', 'like', '%tata-naskah-dinas%')->first();
                if ($existingRow) {
                    $itemId = $existingRow->id;
                } else {
                    $item = new Infografis;
                    $item->thumbnail = json_encode([
                        'path' => 'images/infografis/tata-naskah-dinas-cover.jpg.webp',
                        'alt_id' => 'Tata Naskah Dinas Kementerian Koordinator Bidang Pangan',
                        'alt_en' => 'Official Document Management of the Coordinating Ministry for Food Affairs',
                    ]);
                    $item->date = '2026-08-26';
                    $item->view_count = 0;
                    $item->is_active = 1;
                    $item->save();
                    $itemId = $item->id;
                }

                $descId = '<p>Kementerian Koordinator Bidang Pangan telah menetapkan Peraturan Menteri Koordinator Bidang Pangan Nomor 5 Tahun 2026 tentang Tata Naskah Dinas Kementerian Koordinator Bidang Pangan.</p><p>Peraturan ini menjadi pedoman dalam penyelenggaraan Tata Naskah Dinas, mulai dari jenis, susunan, dan bentuk Naskah Dinas, pembuatan, pengamanan, pejabat penandatangan, hingga pengendalian Naskah Dinas untuk mendukung tertib administrasi dan komunikasi kedinasan di lingkungan Kementerian Koordinator Bidang Pangan.</p>';
                $descEn = '<p>The Coordinating Ministry for Food Affairs has enacted Regulation of the Coordinating Minister for Food Affairs Number 5 of 2026 concerning Official Document Management of the Coordinating Ministry for Food Affairs.</p><p>This regulation serves as a guideline for organizing Official Document Management, covering types, structure, and format of Official Documents, drafting, security, signing officials, and control of Official Documents to support administrative order and official communication within the Coordinating Ministry for Food Affairs.</p>';

                \DB::table('infografis_lang')->where('base_id', $itemId)->delete();
                \DB::table('infografis_lang')->insert([
                    [
                        'base_id' => $itemId,
                        'lang' => 'id',
                        'title' => 'Tata Naskah Dinas Kementerian Koordinator Bidang Pangan',
                        'description' => $descId,
                    ],
                    [
                        'base_id' => $itemId,
                        'lang' => 'en',
                        'title' => 'Official Document Management of the Coordinating Ministry for Food Affairs',
                        'description' => $descEn,
                    ],
                ]);

                foreach ([
                    'id' => ['tata-naskah-dinas-kementerian-koordinator-bidang-pangan', 'Tata Naskah Dinas Kementerian Koordinator Bidang Pangan'],
                    'en' => ['tata-naskah-dinas-kementerian-koordinator-bidang-pangan-en', 'Official Document Management of the Coordinating Ministry for Food Affairs'],
                ] as $langCode => $pData) {
                    $p = new \Cactuar\Admin\Models\Permalink;
                    $p->uniqid = $itemId;
                    $p->module = 'information-infografis';
                    $p->lang = $langCode;
                    $p->permalink = $pData[0];
                    $p->label = $pData[1];
                    $p->description = '';
                    $p->searchable = $pData[1];
                    $p->save();
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('Sync Tata Naskah Dinas Infografis failed: ' . $e->getMessage());
        }

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
        $others = Infografis::translate()->whereIsActive(1)->where('id', '!=', $infografis->id)
            ->inRandomOrder()
            ->limit(4)
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
        
        $kamus = $kamus->orderBy('title', 'asc')->paginate(6);
        
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
        
        $documents = $documents->orderBy('tanggal_penetapan', 'desc')->paginate(8);

        $rule_types = RuleType::whereIsActive(1)->get();
        $rule_themes = RuleTheme::whereIsActive(1)->get();
        $years = Document::select('year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PERATURAN)
            ->orderBy('year', 'desc')
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
        
        $documents = $documents->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(12);

        $years = Document::select('tahun_terbit')
            ->whereIsActive(1)
            ->where('master_document_id', Document::JURNAL)
            ->orderBy('tahun_terbit', 'desc')
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
        
        $documents = $documents->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(12);

        $years = Document::select('tahun_terbit')
            ->whereIsActive(1)
            ->where('master_document_id', Document::KLIPING)
            ->orderBy('tahun_terbit', 'desc')
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
        
        $documents = $documents->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(12);

        $years = Document::select('tahun_terbit')
            ->whereIsActive(1)
            ->where('master_document_id', Document::MAJALAH)
            ->orderBy('tahun_terbit', 'desc')
            ->groupBy('tahun_terbit')
            ->get();
        
        return view('dynamic.pages.document-article', compact('menu', 'documents', 'years'));
    }

    public function getPutusanHukum($menu, $courtType = null)
    {
        $court = $courtType ?: request()->query('court');
        $query = Document::translate()->whereIsActive(1)->where('master_document_id', Document::PUTUSAN);

        if ($court) {
            $court = strtoupper(trim($court));
            if ($court === 'MAHKAMAH-AGUNG' || $court === 'MA') {
                $query->where(function($q) {
                    $q->where('documents.court_type', 'MA')
                      ->orWhere('documents_lang.jenis_peradilan', 'like', '%Mahkamah Agung%')
                      ->orWhere('documents_lang.singkatan_peradilan', 'MA');
                });
                $court = 'MA';
            } elseif ($court === 'MAHKAMAH-KONSTITUSI' || $court === 'MK') {
                $query->where(function($q) {
                    $q->where('documents.court_type', 'MK')
                      ->orWhere('documents_lang.jenis_peradilan', 'like', '%Mahkamah Konstitusi%')
                      ->orWhere('documents_lang.singkatan_peradilan', 'MK');
                });
                $court = 'MK';
            }
        }

        if (request()->query('search')) {
            $search = request()->query('search');
            $query->where(function($q) use ($search) {
                $q->where('documents_lang.title', 'like', '%'.$search.'%')
                  ->orWhere('documents.no_putusan', 'like', '%'.$search.'%')
                  ->orWhere('documents_lang.intro', 'like', '%'.$search.'%')
                  ->orWhere('documents_lang.subjek', 'like', '%'.$search.'%')
                  ->orWhere('documents_lang.bidang_hukum', 'like', '%'.$search.'%')
                  ->orWhere('documents_lang.pokok_perkara', 'like', '%'.$search.'%')
                  ->orWhere('documents_lang.pemohon', 'like', '%'.$search.'%');
            });
        }

        if (request()->query('no_putusan')) {
            $query->where('documents.no_putusan', 'like', '%'.request()->query('no_putusan').'%');
        }

        if (request()->query('year')) {
            $yearVal = request()->query('year');
            $query->where(function($q) use ($yearVal) {
                $q->whereYear('documents.tanggal_dibacakan', $yearVal)
                  ->orWhere('documents.year', $yearVal);
            });
        }

        if (request()->query('sort') == 'oldest') {
            $query->orderBy('documents.updated_at', 'asc')->orderBy('documents.created_at', 'asc');
        } else {
            $query->orderBy('documents.updated_at', 'desc')->orderBy('documents.created_at', 'desc')->orderBy('documents.id', 'desc');
        }
        
        $documents = $query->paginate(8);

        $years = Document::selectRaw('COALESCE(year, YEAR(tanggal_dibacakan)) as year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PUTUSAN)
            ->whereNotNull('tanggal_dibacakan')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        return view('dynamic.pages.document-putusan', compact('menu', 'documents', 'years', 'court'));
    }

    public function getPutusanHukumRoute()
    {
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'putusan-hukum')->first() ?? Menu::find(16) ?? Menu::first();
        return $this->getPutusanHukum($menu, null);
    }

    public function getPutusanMa()
    {
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'putusan-hukum')->first() ?? Menu::find(16) ?? Menu::first();
        return $this->getPutusanHukum($menu, 'MA');
    }

    public function getPutusanMk()
    {
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'putusan-hukum')->first() ?? Menu::find(16) ?? Menu::first();
        return $this->getPutusanHukum($menu, 'MK');
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
        
        $documents = $documents->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(12);

        $years = Document::select('tahun_terbit')
            ->whereIsActive(1)
            ->where('master_document_id', Document::MONOGRAFI)
            ->orderBy('tahun_terbit', 'desc')
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
        
        $documents = $documents->orderBy('tanggal_berlaku', 'desc')->orderBy('id', 'desc')->paginate(8);

        $years = Document::selectRaw('YEAR(tanggal_berlaku) as year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::NASKAH)
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        return view('dynamic.pages.document-naskah', compact('menu', 'documents', 'years'));
    }

    public function getPeraturanTerjemahan($menu)
    {
        $documents = Document::translate()
            ->whereIsActive(1)
            ->where(function($query) {
                $query->where('master_document_id', Document::PERATURAN_TERJEMAHAN)
                    ->orWhere(function($sub) {
                        $sub->whereIn('master_document_id', [Document::PERATURAN, Document::PERATURAN_TERJEMAHAN])
                            ->where('has_translation', 1);
                    });
            });

        if ($search = request()->query('search')) {
            $documents = $documents->where(function($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                  ->orWhere('translation_title', 'like', '%'.$search.'%')
                  ->orWhere('no_peraturan', 'like', '%'.$search.'%')
                  ->orWhere('translation_no_peraturan', 'like', '%'.$search.'%');
            });
        }

        if ($year = request()->query('year')) {
            $documents = $documents->where('year', $year);
        }

        if ($ruleType = request()->query('rule_type')) {
            $documents = $documents->where('rule_type_id', $ruleType);
        }
        
        $documents = $documents->orderBy('tanggal_penetapan', 'desc')->orderBy('id', 'desc')->paginate(8);

        $years = Document::select('year')
            ->whereIsActive(1)
            ->where(function($query) {
                $query->where('master_document_id', Document::PERATURAN_TERJEMAHAN)
                    ->orWhere(function($sub) {
                        $sub->whereIn('master_document_id', [Document::PERATURAN, Document::PERATURAN_TERJEMAHAN])
                            ->where('has_translation', 1);
                    });
            })
            ->whereNotNull('year')
            ->orderBy('year', 'desc')
            ->groupBy('year')
            ->get();
        
        $rule_types = \App\Models\RuleType::whereIsActive(1)->orderBy('id', 'asc')->get();

        return view('dynamic.pages.document-peraturan-terjemahan', compact('menu', 'documents', 'years', 'rule_types'));
    }

    public function getProgramPenyusunanPuu($menu)
    {
        $isEn = app()->getLocale() === 'en';
        og::set(
            'title',
            $isEn ? 'Legislation Drafting Program' : 'Program Penyusunan PUU'
        );
        og::set(
            'description',
            $isEn
                ? 'Legislation Drafting Program of the Coordinating Ministry for Food Affairs of the Republic of Indonesia'
                : 'Program Penyusunan Peraturan Perundang-Undangan Kementerian Koordinator Bidang Pangan Republik Indonesia'
        );

        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::PROGRAM_PENYUSUNAN);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $documents = $documents->where('year', request()->query('year'));
        }

        $documents = $documents->orderBy('tanggal_penetapan', 'desc')->orderBy('id', 'desc')->paginate(8);
        $years = Document::select('year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::PROGRAM_PENYUSUNAN)
            ->whereNotNull('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        return view('dynamic.pages.document-program-penyusunan', compact('menu', 'documents', 'years'));
    }

    public function getNaskahAkademik($menu)
    {
        // Otomatis tarik harmon_naskah_urgensi dari e-Regulasi yang belum tersinkron ke NASKAH_AKADEMIK
        \App\Models\Regulasi::whereNotNull('harmon_naskah_urgensi')
            ->where('harmon_naskah_urgensi', '!=', '')
            ->doesntHave('naskahUrgensiDocument')
            ->get()
            ->each(function ($reg) {
                $reg->syncNaskahUrgensiDocument();
            });

        $baseQuery = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::NASKAH_AKADEMIK);

        if (request()->query('search')) {
            $search = request()->query('search');
            $baseQuery->where('documents_lang.title', 'like', '%' . $search . '%');
        }

        if (request()->query('year')) {
            $baseQuery->where('documents.year', request()->query('year'));
        }

        $documents = $baseQuery
            ->orderByRaw('COALESCE(documents.tanggal_penetapan, documents.date, DATE(documents.created_at)) DESC')
            ->orderBy('documents.id', 'desc')
            ->paginate(8);

        $years = Document::whereIsActive(1)
            ->where('master_document_id', Document::NASKAH_AKADEMIK)
            ->whereNotNull('year')
            ->select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        return view('dynamic.pages.document-naskah-akademik', compact('menu', 'documents', 'years'));
    }

    public function getAnalisisEvaluasi($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::ANALISIS_EVALUASI);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }
        if (request()->query('year')) {
            $documents = $documents->where('documents.year', request()->query('year'));
        }

        $documents = $documents->orderByRaw('COALESCE(documents.tanggal_penetapan, documents.date, DATE(documents.created_at)) DESC')
            ->orderBy('documents.id', 'desc')
            ->paginate(8);
        $years = Document::whereIsActive(1)
            ->where('master_document_id', Document::ANALISIS_EVALUASI)
            ->whereNotNull('year')
            ->select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();
        return view('dynamic.pages.document-analisis-evaluasi', compact('menu', 'documents', 'years'));
    }

    private function syncRisalahPembahasan2026(): void
    {
        try {
            $items = [
                [
                    'slug' => 'risalah-rapat-harmonisasi-r-permenko-bidang-pangan-tentang-tata-kerja-tim-terpadu-dan-tim-pelaksana-pengendalian-alih-fungsi-lahan-sawah',
                    'title' => 'Risalah Rapat Harmonisasi R-Permenko Bidang Pangan tentang Tata Kerja Tim Terpadu Pengendalian Alih Fungsi Lahan Sawah dan Tim Pelaksana Pengendalian Alih Fungsi Lahan Sawah',
                    'date' => '2026-03-05',
                    'year' => 2026,
                    'tempat_penetapan' => 'Jakarta',
                    'pihak_internal' => 'Kemenko Bidang Pangan, Kementerian Hukum, Kemenko Infrastruktur dan Pembangunan Kewilayahan, Kemenko Perekonomian, Kemensetneg, Kementerian ATR/BPN, Kementerian Pertanian, Kementerian Kehutanan, Kementerian Lingkungan Hidup, Kementerian PPN/Bappenas, Kemendagri, Kementerian Keuangan, Kementerian PKP, Kementerian Transmigrasi, BPS, BIG, dan KPK',
                    'teu' => 'Deputi Bidang Koordinasi Usaha Pangan dan Pertanian',
                    'unit_penanggungjawab' => 'Biro Hukum dan Kerja Sama',
                    'subjek' => 'Pengendalian Alih Fungsi Lahan Sawah (LSD)',
                    'pdf' => 'pdf/risalah/risalah-harmonisasi-permenko-afls-2026-03-05.pdf',
                    'pdf_name' => 'Risalah Pembahasan 2/2026',
                    'related_rancangan_id' => 171,
                    'related_peraturan_id' => 58,
                    'intro' => '<p>Rapat Harmonisasi Rancangan Peraturan Menteri Koordinator Bidang Pangan tentang Tata Kerja Tim Terpadu Pengendalian Alih Fungsi Lahan Sawah dan Tim Pelaksana Pengendalian Alih Fungsi Lahan Sawah yang dilaksanakan pada tanggal 5 Maret 2026 dan 9 Maret 2026 menindaklanjuti Surat Dinas Nomor PPE.PP.01.05-718 oleh Direktorat Jenderal Peraturan Perundang-undangan Kementerian Hukum RI sebagai pelaksanaan Pasal 5 Peraturan Presiden Nomor 4 Tahun 2026.</p>',
                    'rekomendasi' => '<p>Disepakati rumusan ruang lingkup tata kerja Tim Terpadu dan Tim Pelaksana Pengendalian Alih Fungsi Lahan Sawah yang meliputi koordinasi pelaksanaan dan verifikasi penetapan, sinkronisasi hasil verifikasi peta Lahan Sawah yang Dilindungi (LSD), pengusulan dan penetapan peta LSD, pemberian insentif, pemberdayaan LSD, serta pemantauan dan evaluasi.</p>',
                ],
                [
                    'slug' => 'risalah-rapat-harmonisasi-r-permenko-bidang-pangan-tentang-tata-naskah-dinas',
                    'title' => 'Risalah Rapat Harmonisasi R-Permenko Bidang Pangan tentang Tata Naskah Dinas di Lingkungan Kementerian Koordinator Bidang Pangan',
                    'date' => '2026-04-29',
                    'year' => 2026,
                    'tempat_penetapan' => 'Bogor',
                    'pihak_internal' => 'Seluruh Biro, Inspektorat, Sekretariat Deputi, dan Pejabat Fungsional Arsiparis di Lingkungan Kementerian Koordinator Bidang Pangan',
                    'teu' => 'Biro Umum dan Hubungan Masyarakat / Biro Hukum dan Kerja Sama',
                    'unit_penanggungjawab' => 'Biro Hukum dan Kerja Sama',
                    'subjek' => 'Tata Naskah Dinas Kementerian Koordinator Bidang Pangan',
                    'pdf' => 'pdf/risalah/risalah-harmonisasi-permenko-tata-naskah-dinas-2026-04-29.pdf',
                    'pdf_name' => 'Risalah Pembahasan 3/2026',
                    'related_rancangan_id' => 183,
                    'related_peraturan_id' => 61,
                    'intro' => '<p>Rapat Pembahasan Harmonisasi dan Finalisasi Rancangan Peraturan Menteri Koordinator Bidang Pangan tentang Tata Naskah Dinas di Lingkungan Kementerian Koordinator Bidang Pangan dilaksanakan pada tanggal 29–30 April 2026 berdasarkan Surat Dinas Nomor 191/KA.01.00/2026 guna menyeragamkan pedoman administrasi persuratan dan pengelolaan arsip di seluruh unit kerja.</p>',
                    'rekomendasi' => '<p>Disepakati pedoman Tata Naskah Dinas yang mengatur jenis dan format naskah dinas, kewenangan penandatanganan, penggunaan kode klasifikasi arsip, pembedaan penggunaan memorandum dan nota dinas, serta penerapan template seragam melalui aplikasi Srikandi di seluruh unit kerja Kemenko Bidang Pangan.</p>',
                ],
                [
                    'slug' => 'risalah-rapat-harmonisasi-r-permenko-bidang-pangan-tentang-piagam-pengawasan-intern',
                    'title' => 'Risalah Rapat Harmonisasi R-Permenko Bidang Pangan tentang Piagam Pengawasan Intern Kementerian Koordinator Bidang Pangan',
                    'date' => '2026-05-04',
                    'year' => 2026,
                    'tempat_penetapan' => 'Jakarta',
                    'pihak_internal' => 'Inspektorat Kemenko Bidang Pangan, Biro Hukum dan Kerja Sama Kemenko Bidang Pangan, dan Direktorat Jenderal Peraturan Perundang-undangan Kementerian Hukum',
                    'teu' => 'Inspektorat Kementerian Koordinator Bidang Pangan',
                    'unit_penanggungjawab' => 'Biro Hukum dan Kerja Sama',
                    'subjek' => 'Piagam Pengawasan Intern (Internal Audit Charter)',
                    'pdf' => 'pdf/risalah/risalah-harmonisasi-permenko-piagam-pengawasan-intern-2026-05-04.pdf',
                    'pdf_name' => 'Risalah Pembahasan 4/2026',
                    'related_rancangan_id' => 172,
                    'related_peraturan_id' => 59,
                    'intro' => '<p>Rapat Harmonisasi Rancangan Peraturan Menteri Koordinator Bidang Pangan tentang Piagam Pengawasan Intern Kementerian Koordinator Bidang Pangan dilaksanakan pada Senin, 4 Mei 2026 berdasarkan Surat Dinas Nomor B-54/INS.M.PANGAN/UND/04/2025 untuk memperkuat fungsi pengawasan intern pemerintah (APIP) yang kompeten, independen, objektif, dan akuntabel.</p>',
                    'rekomendasi' => '<p>Harmonisasi dinyatakan selesai dengan penyempurnaan konsiderans Menimbang serta penyesuaian lampiran mengenai kedudukan, peran, kewenangan, kode etik, dan penilaian berkala Inspektorat sesuai Standar Audit Intern Pemerintah Indonesia.</p>',
                ],
                [
                    'slug' => 'risalah-rapat-harmonisasi-r-permenko-bidang-pangan-tentang-keterlibatan-tim-koordinasi-penyelenggaraan-program-makan-bergizi-gratis',
                    'title' => 'Risalah Rapat Harmonisasi R-Permenko Bidang Pangan tentang Keterlibatan Tim Koordinasi Penyelenggaraan Program Makan Bergizi Gratis',
                    'date' => '2026-05-11',
                    'year' => 2026,
                    'tempat_penetapan' => 'Bogor',
                    'pihak_internal' => 'Kemenko Bidang Pangan, Kemenko PMK, Kemenko Pemberdayaan Masyarakat, Kementerian Hukum, Kemensetneg, Kemendagri, Kementerian Keuangan, Kementerian PPN/Bappenas, Kementerian PANRB, dan Badan Gizi Nasional',
                    'teu' => 'Deputi Bidang Koordinasi Keterjangkauan dan Keamanan Pangan',
                    'unit_penanggungjawab' => 'Biro Hukum dan Kerja Sama',
                    'subjek' => 'Koordinasi Penyelenggaraan Program Makan Bergizi Gratis (MBG)',
                    'pdf' => 'pdf/risalah/risalah-harmonisasi-permenko-tim-koordinasi-mbg-2026-05-11.pdf',
                    'pdf_name' => 'Risalah Pembahasan 5/2026',
                    'related_rancangan_id' => 173,
                    'related_peraturan_id' => 60,
                    'intro' => '<p>Rapat Pengharmonisasian Rancangan Peraturan Menteri Koordinator Bidang Pangan tentang Keterlibatan Tim Koordinasi Penyelenggaraan Program Makan Bergizi Gratis dilaksanakan pada Senin, 11 Mei 2026 di Bogor menindaklanjuti Surat Undangan Direktorat Jenderal Peraturan Perundang-undangan Kementerian Hukum Nomor PPE.PP.01.05.1508.</p>',
                    'rekomendasi' => '<p>Disepakati pengaturan mekanisme sinkronisasi, koordinasi, pemantauan, evaluasi, serta pelaporan Tim Koordinasi Penyelenggaraan Program Makan Bergizi Gratis lintas kementerian/lembaga dan pemerintah daerah.</p>',
                ],
                [
                    'slug' => 'risalah-rapat-harmonisasi-r-permenko-bidang-pangan-tentang-perubahan-kedua-atas-permenko-nomor-1-tahun-2024-tentang-organisasi-dan-tata-kerja',
                    'title' => 'Risalah Rapat Harmonisasi R-Permenko Bidang Pangan tentang Perubahan Kedua atas Peraturan Menteri Koordinator Bidang Pangan Nomor 1 Tahun 2024 tentang Organisasi dan Tata Kerja Kementerian Koordinator Bidang Pangan',
                    'date' => '2026-09-08',
                    'year' => 2026,
                    'tempat_penetapan' => 'Jakarta',
                    'pihak_internal' => 'Kementerian Koordinator Bidang Pangan, Kementerian Hukum, Kementerian PANRB, dan Badan Kepegawaian Negara',
                    'teu' => 'Biro Sumber Daya Manusia dan Organisasi / Biro Hukum dan Kerja Sama',
                    'unit_penanggungjawab' => 'Biro Hukum dan Kerja Sama',
                    'subjek' => 'Perubahan Kedua Organisasi dan Tata Kerja Kemenko Bidang Pangan',
                    'pdf' => 'pdf/risalah/risalah-harmonisasi-permenko-perubahan-kedua-otk-2026-09-08.pdf',
                    'pdf_name' => 'Risalah Pembahasan 6/2026',
                    'related_rancangan_id' => 184,
                    'related_peraturan_id' => 64,
                    'intro' => '<p>Rapat Harmonisasi Rancangan Peraturan Menteri Koordinator Bidang Pangan tentang Perubahan Kedua atas Peraturan Menteri Koordinator Bidang Pangan Nomor 1 Tahun 2024 tentang Organisasi dan Tata Kerja Kementerian Koordinator Bidang Pangan dilaksanakan di Jakarta pada tanggal 8 September 2026 menindaklanjuti surat Direktorat Jenderal Peraturan Perundang-undangan Kementerian Hukum Nomor PPE.PP.01.05-3173.</p>',
                    'rekomendasi' => '<p>Disepakati penyempurnaan struktur organisasi dan tata kerja Kemenko Bidang Pangan yang mencakup penegasan tugas dan kewenangan Wakil Menteri Koordinator, konsistensi pembagian fungsi antarunit kerja, serta kesesuaian nomenklatur berdasarkan persetujuan Menteri PANRB.</p>',
                ],
                [
                    'slug' => 'risalah-rapat-harmonisasi-r-permenko-bidang-pangan-tentang-pemberian-tunjangan-kinerja-pegawai',
                    'title' => 'Risalah Rapat Harmonisasi R-Permenko Bidang Pangan tentang Perubahan atas Peraturan Menteri Koordinator Bidang Pangan Nomor 4 Tahun 2025 tentang Pelaksanaan Pemberian Tunjangan Kinerja bagi Pegawai di Lingkungan Kementerian Koordinator Bidang Pangan',
                    'date' => '2026-09-11',
                    'year' => 2026,
                    'tempat_penetapan' => 'Jakarta',
                    'pihak_internal' => 'Kementerian Koordinator Bidang Pangan, Kementerian Hukum, Kementerian Keuangan, Kementerian PANRB, dan Badan Kepegawaian Negara',
                    'teu' => 'Biro Sumber Daya Manusia dan Organisasi',
                    'unit_penanggungjawab' => 'Biro Hukum dan Kerja Sama',
                    'subjek' => 'Pelaksanaan Pemberian Tunjangan Kinerja Pegawai',
                    'pdf' => 'pdf/risalah/risalah-harmonisasi-permenko-tunjangan-kinerja-2026-09-11.pdf',
                    'pdf_name' => 'Risalah Pembahasan 7/2026',
                    'related_rancangan_id' => 176,
                    'related_peraturan_id' => 63,
                    'intro' => '<p>Rapat Harmonisasi Rancangan Peraturan Menteri Koordinator Bidang Pangan tentang Perubahan atas Peraturan Menteri Koordinator Bidang Pangan Nomor 4 Tahun 2025 tentang Pelaksanaan Pemberian Tunjangan Kinerja bagi Pegawai di Lingkungan Kementerian Koordinator Bidang Pangan dilaksanakan pada tanggal 11 September 2026 menindaklanjuti surat Direktorat Jenderal Peraturan Perundang-undangan Kementerian Hukum Nomor PPE.PP.01.05-3254.</p>',
                    'rekomendasi' => '<p>Disepakati penyesuaian ketentuan pemberian dan pembayaran tunjangan kinerja di lingkungan Kementerian Koordinator Bidang Pangan sehubungan dengan perkembangan struktur kelembagaan dan pengangkatan Wakil Menteri Koordinator Bidang Pangan.</p>',
                ],
            ];

            // Pastikan dokumen #185 yang sudah ada memiliki year=2025 dan tanggal_penetapan=2025-12-31
            \DB::table('documents')
                ->where('id', 185)
                ->where('master_document_id', Document::RISALAH_PEMBAHASAN)
                ->update([
                    'year' => '2025',
                    'tanggal_penetapan' => '2025-12-31',
                ]);

            foreach ($items as $row) {
                $exists = \Cactuar\Admin\Models\Permalink::where('module', 'puu-risalah')
                    ->where('permalink', $row['slug'])
                    ->exists();
                if ($exists) {
                    continue;
                }

                $doc = new Document;
                $doc->master_document_id = Document::RISALAH_PEMBAHASAN;
                $doc->related_document_id = $row['related_rancangan_id'];
                $doc->date = $row['date'];
                $doc->tanggal_penetapan = $row['date'];
                $doc->year = (string) $row['year'];
                $doc->tempat_penetapan = $row['tempat_penetapan'];
                $doc->pihak_internal = $row['pihak_internal'];
                $doc->pdf = $row['pdf'];
                $doc->is_active = 1;
                $doc->status_berlaku = 1;
                $doc->view_count = 0;
                $doc->download_pdf_count = 0;
                $doc->save();

                foreach (['id', 'en'] as $lang) {
                    \DB::table('documents_lang')->insert([
                        'base_id' => $doc->id,
                        'lang' => $lang,
                        'title' => $row['title'],
                        'teu' => $row['teu'],
                        'intro' => $row['intro'],
                        'rekomendasi' => $row['rekomendasi'],
                        'pdf_name' => $row['pdf_name'],
                        'bahasa' => 'Indonesia',
                        'bidang_hukum' => 'Hukum Administrasi',
                        'subjek' => $row['subjek'],
                        'unit_pemrakarsa' => $row['unit_penanggungjawab'],
                    ]);

                    $p = new \Cactuar\Admin\Models\Permalink;
                    $p->uniqid = $doc->id;
                    $p->module = 'puu-risalah';
                    $p->lang = $lang;
                    $p->permalink = $lang === 'en' ? ($row['slug'] . '-en') : $row['slug'];
                    $p->label = \Illuminate\Support\Str::limit($row['title'], 250, '');
                    $p->description = strip_tags($row['intro']);
                    $p->searchable = $row['title'] . ' ' . $row['subjek'];
                    $p->save();
                }

                // Isi CMS Dynamic Metadata (field_id 48..57 untuk master_document_id = 12)
                $metaMap = [
                    48 => 'Risalah Pembahasan PUU',
                    49 => '-',
                    50 => $row['tempat_penetapan'],
                    51 => $row['unit_penanggungjawab'],
                    52 => (string) $row['year'],
                    53 => '-',
                    54 => $row['subjek'],
                    55 => 'Indonesia',
                    56 => 'Hukum Administrasi',
                    57 => '-',
                ];
                foreach ($metaMap as $fieldId => $val) {
                    \DB::table('document_metadata_values')->updateOrInsert(
                        ['document_id' => $doc->id, 'field_id' => $fieldId],
                        ['value' => $val, 'created_at' => now(), 'updated_at' => now()]
                    );
                }

                // Hubungkan Peraturan Terkait di document_relations
                if (!empty($row['related_peraturan_id'])) {
                    \DB::table('document_relations')->updateOrInsert(
                        [
                            'source_document_id' => $doc->id,
                            'related_document_id' => $row['related_peraturan_id'],
                            'relation_group' => 'peraturan_terkait',
                        ],
                        [
                            'relation_type' => 'terkait',
                            'is_external' => 0,
                            'notes' => '',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('syncRisalahPembahasan2026 failed: ' . $e->getMessage());
        }
    }

    public function getRisalahPembahasan($menu)
    {
        $this->syncRisalahPembahasan2026();

        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::RISALAH_PEMBAHASAN);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }
        if (request()->query('year')) {
            $documents = $documents->where(function ($q) {
                $y = request()->query('year');
                $q->where('documents.year', $y)
                  ->orWhereRaw('YEAR(documents.date) = ?', [$y]);
            });
        }
        
        $documents = $documents->orderByRaw('COALESCE(documents.date, documents.tanggal_penetapan, DATE(documents.created_at)) DESC')
            ->orderBy('documents.id', 'desc')
            ->paginate(8);
        $years = Document::whereIsActive(1)
            ->where('master_document_id', Document::RISALAH_PEMBAHASAN)
            ->selectRaw('COALESCE(year, YEAR(date)) as year')
            ->whereRaw('COALESCE(year, YEAR(date)) IS NOT NULL')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();
        return view('dynamic.pages.document-risalah-pembahasan', compact('menu', 'documents', 'years'));
    }

    public function getKajianHukum($menu)
    {
        $documents = Document::translate()->whereIsActive(1)->where('master_document_id', Document::KAJIAN_HUKUM);

        if (request()->query('search')) {
            $documents = $documents->where('title', 'like', '%'.request()->query('search').'%');
        }
        
        $documents = $documents->orderBy('tanggal_penetapan', 'desc')->orderBy('id', 'desc')->paginate(8);
        $years = collect();
        return view('dynamic.pages.document-kajian-hukum', compact('menu', 'documents', 'years'));
    }

    public function getPartisipasiPublik($menu = null)
    {
        return app(\App\Http\Controllers\ERegulasi\PartisipasiPublikController::class)->index(request(), $menu);
    }

    public function getAksesibilitas($menu = null)
    {
        if (!$menu) {
            $menu = Menu::find(39) ?? Menu::fe()->whereIsActive(1)->where('type', 'aksesibilitas')->first() ?? Menu::first();
        }

        $videos = Gallery::translate()
            ->with('classifications')
            ->whereIsActive(1)
            ->where('type', 'video')
            ->whereHas('classifications', function ($q) {
                $q->where('code', 'aksesibilitas');
            });

        if (request()->query('search')) {
            $videos = $videos->where('title', 'like', '%' . request()->query('search') . '%');
        }

        if (request()->query('sort') === 'oldest') {
            $videos = $videos->orderBy('date', 'asc');
        } else {
            $videos = $videos->orderBy('sort_id', 'asc')->orderBy('date', 'desc');
        }

        $videos = $videos->paginate(6);

        return view('dynamic.pages.informasi-aksesibilitas', compact('menu', 'videos'));
    }

    public function getVideografis($menu)
    {
        return view('dynamic.pages.informasi-videografis', compact('menu'));
    }

    public function getRancanganPuu($menu)
    {
        try {
            \App\Models\Regulasi::doesntHave('document')->get()->each->syncToJdihDocument();
        } catch (\Throwable $e) {}

        $candidates = Document::translate()
            ->whereIsActive(1)
            ->where('master_document_id', Document::RANCANGAN_PUU)
            ->whereNotNull('documents.regulasi_id')
            ->whereHas('regulasi');

        if (request()->query('search')) {
            $candidates = $candidates->where('title', 'like', '%'.request()->query('search').'%');
        }

        if (request()->query('year')) {
            $candidates = $candidates->where('year', request()->query('year'));
        }

        if (request()->query('tahapan')) {
            $candidates = $candidates->where('tahapan_puu_id', request()->query('tahapan'));
        }

        $allCandidates = $candidates->with(['regulasi.partisipasiPublik'])->get();

        // Pastikan tiap judul rancangan hanya tampil 1x dengan tahapan/status update terakhir dari e-Regulasi
        $pickedByTitle = [];
        foreach ($allCandidates as $doc) {
            $reg = $doc->regulasi;
            if (!$reg) {
                continue;
            }

            $rawTitle = $doc->translated('title') ?: $reg->judul ?: '';
            $normTitle = mb_strtolower(trim(preg_replace('/\s+/', ' ', strip_tags($rawTitle))));
            if ($normTitle === '') {
                $normTitle = 'regulasi-' . $reg->id;
            }

            $stageRank = $reg->stagePriority();
            $updatedTs = $reg->updated_at ? $reg->updated_at->timestamp : 0;
            $regId = (int) $reg->id;

            if (!isset($pickedByTitle[$normTitle])) {
                $pickedByTitle[$normTitle] = $doc;
            } else {
                $existingReg = $pickedByTitle[$normTitle]->regulasi;
                $exStage = $existingReg ? $existingReg->stagePriority() : 0;
                $exUpdated = ($existingReg && $existingReg->updated_at) ? $existingReg->updated_at->timestamp : 0;
                $exId = $existingReg ? (int) $existingReg->id : 0;

                $isNewer = ($stageRank > $exStage)
                    || ($stageRank === $exStage && $updatedTs > $exUpdated)
                    || ($stageRank === $exStage && $updatedTs === $exUpdated && $regId > $exId);

                if ($isNewer) {
                    $pickedByTitle[$normTitle] = $doc;
                }
            }
        }

        // Urutkan sesuai Daftar Pengajuan PUU (tanggal usulan terbaru -> status update terakhir -> id terbaru)
        $uniqueDocs = collect(array_values($pickedByTitle))->sort(function ($a, $b) {
            $regA = $a->regulasi;
            $regB = $b->regulasi;
            $dateA = $regA && $regA->tgl_usulan ? $regA->tgl_usulan->format('Y-m-d') : ($regA && $regA->created_at ? $regA->created_at->format('Y-m-d') : '1970-01-01');
            $dateB = $regB && $regB->tgl_usulan ? $regB->tgl_usulan->format('Y-m-d') : ($regB && $regB->created_at ? $regB->created_at->format('Y-m-d') : '1970-01-01');
            if ($dateA !== $dateB) {
                return strcmp($dateB, $dateA);
            }
            $updA = $regA && $regA->updated_at ? $regA->updated_at->timestamp : 0;
            $updB = $regB && $regB->updated_at ? $regB->updated_at->timestamp : 0;
            if ($updA !== $updB) {
                return $updB <=> $updA;
            }
            return ($regB->id ?? 0) <=> ($regA->id ?? 0);
        })->values();

        $perPage = 8;
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $documents = new \Illuminate\Pagination\LengthAwarePaginator(
            $uniqueDocs->forPage($currentPage, $perPage)->values(),
            $uniqueDocs->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $years = Document::select('year')
            ->whereIsActive(1)
            ->where('master_document_id', Document::RANCANGAN_PUU)
            ->whereNotNull('documents.regulasi_id')
            ->whereHas('regulasi')
            ->whereNotNull('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();

        return view('dynamic.pages.document-rancangan-puu', compact('menu', 'documents', 'years'));
    }
}
