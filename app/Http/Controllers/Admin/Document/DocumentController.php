<?php

namespace App\Http\Controllers\Admin\Document;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\CreateTrait;
use Cactuar\Admin\Traits\Controllers\EditTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\PublishTrait;

use App\Models\Document;

use App\Helpers\Document as Helper;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    use BaseTrait, ListingTrait, CreateTrait, EditTrait, DeleteTrait, PublishTrait;

    private $document;

    public function __construct()
    {
        $module = explode('-', $this->module());
        
        $this->document = end($module) ?: 'peraturan';
    }

    public function listingRes()
    {
        $model = Document::translate()->where('master_document_id', Document::getId($this->document));
        
        return $model;
    }

    public function listingFields()
    {
        return Helper::listingFields($this->document);
    }

    public function listingCallback($key,$value,$item,$type)
    {
        if ($key == 'rule_type_id') {
            return $item->rule_type->label ?? '';
        } else if ($key == 'rule_theme_id') {
            return $item->rule_theme->label ?? '';
        } else if ($key == 'tanggal_penetapan') {
            return date2string($value);
        } else if ($key == 'tanggal_pengundangan') {
            return date2string($value);
        } else if ($key == 'status_berlaku') {
            return $item->display_status_berlaku;
        } else if ($key == 'status_tersedia') {
            return $item->front_status_tersedia;
        }

        return e($value);
    }

    public function listingSearchs()
    {
        return ['title'];
    }

    public function listingOrderDefault($res)
    {
        return $res->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->orderBy('id', 'desc');
    }

    public function formRes()
    {
        return new Document;
    }

    public function formCallbackBefore($post,$item,$type)
    {
        $request = request()->all();
        if ($type == 'create') 
            $post['main']['master_document_id'] = Document::getId($this->document);
        
        if ($type == 'create' || $type == 'edit') {
            if (isset($request['pdf']) && $request['pdf'] != null) {
                if ($type == 'edit' && $item->pdf != null) {
                    if (Storage::exists($item->pdf))
                        Storage::delete($item->pdf);
                }

                $original = pathinfo($request['pdf']->getClientOriginalName(), PATHINFO_FILENAME);
                $ext = $request['pdf']->getClientOriginalExtension();
                $filename = $original . '_' . time() . '.' . $ext;
                $path = $request['pdf']->storeAs('upload/pdf', $filename);
                
                $post['main']['pdf'] = $path;
            } else if ($type == 'edit' && $item->pdf != null) {
                $post['main']['pdf'] = $item->pdf;
            }

            if (isset($request['abstract']) && $request['abstract'] != null) {
                if ($type == 'edit' && $item->abstract != null) {
                    if (Storage::exists($item->abstract))
                        Storage::delete($item->abstract);
                }
                $original = pathinfo($request['abstract']->getClientOriginalName(), PATHINFO_FILENAME);
                $ext = $request['abstract']->getClientOriginalExtension();
                $filename = $original . '_' . time() . '.' . $ext;

                $path = $request['abstract']->storeAs('upload/abstract', $filename);
                $post['main']['abstract'] = $path;
            } else if ($type == 'edit' && $item->abstract != null) {
                $post['main']['abstract'] = $item->abstract;
            }
        }
        
        return $post;
    }

    public function formFields($type)
    {
        $form = Helper::formFields($this->document, $type);
        
        $form += [
            'meta' => [
                'type' => 'meta'
            ]  
        ];
        return $form;
    }

    public function formCallbackAfter($item, $type)
    {
        return Helper::formCallbackAfter($item, $type);
    }

    public function apiSearchRelated(Request $request)
    {
        $q = trim($request->input('q', ''));
        $year = $request->input('year');
        $category = $request->input('category', 'all');
        $excludeId = $request->input('exclude_id');

        $query = Document::translate()->with(['master_document', 'rule_type']);

        if (!empty($excludeId)) {
            $query->where('documents.id', '!=', (int)$excludeId);
        }

        if ($category === 'peraturan') {
            $query->where('documents.master_document_id', Document::PERATURAN);
        } else if ($category === 'dokumen') {
            $query->where('documents.master_document_id', '!=', Document::PERATURAN);
        }

        if (!empty($year)) {
            $query->whereYear('documents.date', (int)$year);
        }

        if (!empty($q)) {
            $query->where(function($sub) use ($q) {
                $sub->where('documents_lang.title', 'LIKE', "%{$q}%")
                    ->orWhere('documents.no_peraturan', 'LIKE', "%{$q}%")
                    ->orWhere('documents.nomor_perjanjian', 'LIKE', "%{$q}%")
                    ->orWhere('documents.no_putusan', 'LIKE', "%{$q}%");
            });
        }

        $results = $query->orderBy('documents.date', 'desc')
            ->select('documents.*')
            ->limit(30)
            ->get();

        $data = $results->map(function($doc) {
            $year = $doc->date ? date('Y', strtotime($doc->date)) : '-';
            $catLabel = optional($doc->master_document)->label ?? 'Dokumen';
            $typeLabel = optional($doc->rule_type)->label ?? $catLabel;
            $number = $doc->no_peraturan ?? $doc->nomor_perjanjian ?? $doc->no_putusan ?? '-';

            return [
                'id' => $doc->id,
                'title' => $doc->translated('title') ?: $doc->title,
                'no_peraturan' => $number,
                'year' => $year,
                'category_label' => $catLabel,
                'type_label' => $typeLabel,
                'is_regulation' => ($doc->master_document_id == Document::PERATURAN),
            ];
        });

        return response()->json($data);
    }

    /**
     * Fetch metadata (Title, Number, Year, Category) from external URL
     */
    public function apiFetchExternalMeta(Request $request)
    {
        $url = trim($request->input('url', ''));

        if (empty($url)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Silakan masukkan URL link terlebih dahulu.',
            ], 422);
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Format URL tidak valid. Pastikan diawali http:// atau https://',
            ], 422);
        }

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language' => 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
            ])
            ->withoutVerifying()
            ->timeout(12)
            ->get($url);

            if (!$response->successful()) {
                return response()->json([
                    'status' => 'partial',
                    'message' => 'Link dapat diakses, namun server tujuan mengembalikan status ' . $response->status() . '. Silakan isi judul manual.',
                    'data' => [
                        'url' => $url,
                        'title' => '',
                        'number' => '',
                        'year' => '',
                        'type' => 'Peraturan',
                    ]
                ]);
            }

            $html = $response->body();
            $title = '';
            $ogTitle = '';

            // 1. OpenGraph title
            if (preg_match('/<meta[^>]+property=[\'"]og:title[\'"][^>]+content=[\'"]([^\'"]+)[\'"]/i', $html, $m)) {
                $ogTitle = html_entity_decode(trim($m[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            } elseif (preg_match('/<meta[^>]+content=[\'"]([^\'"]+)[\'"][^>]+property=[\'"]og:title[\'"]/i', $html, $m)) {
                $ogTitle = html_entity_decode(trim($m[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }

            // 2. Standard <title>
            if (preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $m)) {
                $title = html_entity_decode(trim(strip_tags($m[1])), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }

            $finalTitle = $ogTitle ?: $title;

            // If title is generic (e.g. "JDIH", "JDIHN", "Home", "Portal", or very short), scan headings
            if (empty($finalTitle) || in_array(strtolower($finalTitle), ['jdih', 'jdihn', 'home', 'beranda', 'portal', 'dokumen', 'detail dokumen']) || strlen($finalTitle) < 8) {
                if (preg_match_all('/<h[1-6][^>]*>(.*?)<\/h[1-6]>/is', $html, $allHeadings)) {
                    foreach ($allHeadings[1] as $heading) {
                        $clean = trim(strip_tags($heading));
                        if (preg_match('/(?:Peraturan|Undang-Undang|Keputusan|Instruksi|Rancangan|Naskah|Putusan)/i', $clean) && strlen($clean) > 15) {
                            $finalTitle = $clean;
                            break;
                        }
                    }
                }
            }

            // Fallback to first h1 if still empty
            if (empty($finalTitle) && preg_match('/<h1[^>]*>(.*?)<\/h1>/is', $html, $m)) {
                $finalTitle = html_entity_decode(trim(strip_tags($m[1])), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }

            // Clean common suffix tags like " - JDIH...", " | JDIHN..."
            $finalTitle = preg_replace('/\s*[-|–]\s*(?:JDIH|JDIHN|Kementerian|Badan|Portal|Website).*$/iu', '', $finalTitle);
            $finalTitle = trim(preg_replace('/\s+/', ' ', $finalTitle));

            // If empty and URL has filename
            if (empty($finalTitle)) {
                $path = parse_url($url, PHP_URL_PATH);
                $filename = basename($path);
                if (!empty($filename)) {
                    $finalTitle = urldecode(pathinfo($filename, PATHINFO_FILENAME));
                }
            }

            // Extract Number & Year
            $number = '';
            $year = '';
            $type = 'Peraturan';

            if (preg_match('/(?:Nomor|No\.?)\s*([0-9A-Za-z\/\.\-]+)\s*(?:Tahun|Thn\.?|Th\.?|\/)?\s*([12][0-9]{3})/iu', $finalTitle, $matchNomor)) {
                $number = trim($matchNomor[1]);
                $year = trim($matchNomor[2]);
            } elseif (preg_match('/\b(19\d{2}|20\d{2})\b/', $finalTitle, $matchYear)) {
                $year = $matchYear[1];
            }

            if (preg_match('/(Undang-Undang|Peraturan Pemerintah|Peraturan Presiden|Peraturan Menteri|Keputusan Menteri|Instruksi Presiden|Peraturan Daerah)/i', $finalTitle, $mType)) {
                $type = ucwords(strtolower($mType[1]));
            } elseif (preg_match('/(Rancangan|Naskah Akademik|Naskah Urgensi|Risalah|Monografi|Putusan)/i', $finalTitle, $mDocType)) {
                $type = ucwords(strtolower($mDocType[1]));
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menarik data dari link!',
                'data' => [
                    'url' => $url,
                    'title' => $finalTitle,
                    'number' => $number,
                    'year' => $year,
                    'type' => $type,
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'partial',
                'message' => 'Tidak dapat terhubung ke link (' . $e->getMessage() . '). Anda tetap bisa memasukkan judul secara manual.',
                'data' => [
                    'url' => $url,
                    'title' => '',
                    'number' => '',
                    'year' => '',
                    'type' => 'Peraturan',
                ]
            ]);
        }
    }

    public function createFile()
    {
        return true;
    }

    public function editFile()
    {
        return true;
    }
}
