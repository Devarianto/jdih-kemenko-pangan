<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Cactuar\Admin\Models\Permalink;
use App\Models\Document;

use Storage;

class DownloadFileController extends Controller
{
    public function getAdminDownloadFile($type, $id)
    {
        $document = Document::findOrFail($id);

        if (in_array($type, ['pdf', 'abstract', 'attachment'])) {
            if ($document->{$type} != null && Storage::exists($document->{$type})) {
                return response()->file(storage_path('app/'. $document->{$type}), [
                    'Content-Type' => 'application/pdf',
                    'Cache-Control' => 'no-cache, no-store, must-revalidate',
                    'Pragma'        => 'no-cache',
                    'Expires'       => '0',
                ]);
            }
        }

        abort(404);
    }

    public function getDocumentDownload($type, $id)
    {
        if (!request()->query('token')) {
            abort(404);
        }
        
        $document = Document::whereIsActive(1)->where('id', $id)->firstOrFail();
        if ($document->{$type} != null && Storage::exists($document->{$type})) {
            $document->{'download_'.$type.'_count'} += 1;
            $document->save();

            return response()->download(storage_path('app/'. $document->{$type}))->setCache(['no_cache' => true]);
        }

        abort(404);
    }

    public function getDocumentStream($type, $id)
    {
        $document = Document::whereIsActive(1)->where('id', $id)->firstOrFail();
        if ($document->{$type} != null && Storage::exists($document->{$type})) {
            return response()->file(storage_path('app/'. $document->{$type}), [
                'Content-Type' => 'application/pdf'
            ]);
        }

        abort(404);
    }
}
