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
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'peraturan-hukum')->first();

        return view('dynamic.pages.document-peraturan-detail', compact('document', 'menu'));
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

    public function getKlipingHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::KLIPING)->where('id', $id)->firstOrFail();
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'kliping-hukum')->first();

        return view('dynamic.pages.document-kliping-detail', compact('document', 'menu'));
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

    public function getPutusanHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::PUTUSAN)->where('id', $id)->firstOrFail();
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'putusan-hukum')->first();

        return view('dynamic.pages.document-putusan-detail', compact('document', 'menu'));
    }

    public function getMonografiHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::MONOGRAFI)->where('id', $id)->firstOrFail();
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'monografi-hukum')->first();

        return view('dynamic.pages.document-monografi-detail', compact('document', 'menu'));
    }

    public function getNaskahHukumDetail()
    {
        $id = Permalink::active()->uniqid;
        $document = Document::whereIsActive(1)->where('master_document_id', Document::NASKAH)->where('id', $id)->firstOrFail();
        $document->view_count += 1;
        $document->save();
        
        $menu = Menu::fe()->whereIsActive(1)->where('type', 'naskah-hukum')->first();

        return view('dynamic.pages.document-naskah-detail', compact('document', 'menu'));
    }
}
