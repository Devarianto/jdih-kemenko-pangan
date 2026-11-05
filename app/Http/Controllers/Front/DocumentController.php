<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cactuar\Admin\Helpers\helper;

use Cactuar\Admin\Models\Menu;
use Cactuar\Admin\Models\Permalink;

use App\Models\Document;
use App\Models\RuleType;
use App\Models\RuleTheme;

class DocumentController extends Controller
{
    public function getPeraturanHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::PERATURAN)->where('id', $id)->firstOrFail();
        $document->timestamps = false;
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'peraturan-hukum')->first();

        return view('dynamic.pages.document-peraturan-detail', compact('document', 'menu'));
    }

    public function getJurnalHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::JURNAL)->where('id', $id)->firstOrFail();
        $document->timestamps = false;
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'jurnal-hukum')->first();

        return view('dynamic.pages.document-jurnal-detail', compact('document', 'menu'));
    }

    public function getKlipingHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::KLIPING)->where('id', $id)->firstOrFail();
        $document->timestamps = false;
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'kliping-hukum')->first();

        return view('dynamic.pages.document-kliping-detail', compact('document', 'menu'));
    }

    public function getMajalahHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::MAJALAH)->where('id', $id)->firstOrFail();
        $document->timestamps = false;
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'majalah-hukum')->first();

        return view('dynamic.pages.document-article-detail', compact('document', 'menu'));
    }

    public function getPutusanHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::PUTUSAN)->where('id', $id)->firstOrFail();
        $document->timestamps = false;
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'putusan-hukum')->first();

        return view('dynamic.pages.document-putusan-detail', compact('document', 'menu'));
    }

    public function getMonografiHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::MONOGRAFI)->where('id', $id)->firstOrFail();
        $document->timestamps = false;
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'monografi-hukum')->first();

        return view('dynamic.pages.document-monografi-detail', compact('document', 'menu'));
    }

    public function getNaskahHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::NASKAH)->where('id', $id)->firstOrFail();
        $document->timestamps = false;
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'naskah-hukum')->first();

        return view('dynamic.pages.document-naskah-detail', compact('document', 'menu'));
    }

    public function getPuuDetail($masterId, $viewName, $menuType = null)
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', $masterId)->where('id', $id)->firstOrFail();
        $document->timestamps = false;
        $document->view_count += 1;
        $document->save();

        $menu = null;
        if ($menuType) {
            $menu = Menu::fe()->whereIsActive(1)->where('type', $menuType)->first();
            if (!$menu) {
                $menuId = Permalink::where('module', 'menu')->where('permalink', $menuType)->value('uniqid');
                if ($menuId) {
                    $menu = Menu::fe()->find($menuId);
                }
            }
        }

        if (!$menu) {
            $menu = Menu::fe()->whereIsActive(1)->where('type', 'peraturan-hukum')->first() ?? (object)['permalink' => url('/')];
        }

        return view($viewName, compact('document', 'menu'));
    }

    public function postPublicFeedback(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:30',
            'institution' => 'nullable|string|max:150',
            'profession' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'feedback' => 'required|string|max:5000',
            'file_attachment' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $path = null;
        if ($request->hasFile('file_attachment')) {
            $file = $request->file('file_attachment');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $path = $file->storeAs('upload/feedbacks', $filename);
        }

        \App\Models\PublicConsultationFeedback::create([
            'document_id' => $request->document_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'institution' => $request->institution,
            'profession' => $request->profession,
            'city' => $request->city,
            'feedback' => $request->feedback,
            'file_attachment' => $path,
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', 'Terima kasih, masukan Anda untuk Rancangan PUU berhasil dikirim dan akan ditelaah oleh Tim Hukum.');
    }
}

