<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Cactuar\Admin\Models\Permalink;
use App\Models\Document;
use App\Models\Project;

use Storage;
use Auth;
use DB;

class DownloadFileController extends Controller
{
    public function getAdminDownloadFile($type, $id)
    {
        $document = Document::findOrFail($id);

        if (in_array($type, ['pdf', 'abstract', 'attachment', 'translation_pdf', 'translation_attachment'])) {
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
            $document->timestamps = false;
            if ($type == 'pdf' || $type == 'translation_pdf') {
                $document->download_pdf_count += 1;
            } elseif (isset($document->{'download_'.$type.'_count'})) {
                $document->{'download_'.$type.'_count'} += 1;
            }
            $document->save();

            return response()->download(storage_path('app/'. $document->{$type}))->setCache(['no_cache' => true]);
        }

        abort(404);
    }

    public function getAPIDocumentDownload($type, $id)
    {
        $document = Document::whereIsActive(1)->where('id', $id)->firstOrFail();
        if ($document->{$type} != null && Storage::exists($document->{$type})) {
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

    public function getProjectDownload($type, $id, $loop)
    {
        try {
            $realId = \Illuminate\Support\Facades\Crypt::decryptString($id);
        } catch (\Throwable $e) {
            abort(404);
        }
        
        $project = null;
        if (Auth::check()) {
            $project = Project::with(['category','applicantDivisions'])->findOrFail($realId);
        } else if (Auth::guard('account')->check()) {
            $project = Project::with(['category','applicantDivisions'])->authUser()->findOrFail($realId);
        } else {
            abort(404);
        }

        if ($type == 'detail') {
            $files = [];
            if (is_string($project->file)) {
                $decoded = json_decode($project->file, true);
                $files = is_array($decoded) ? $decoded : (empty($project->file) ? [] : [$project->file]);
            }
            $no = 1;
            foreach ($files as $file) {
                if ($no == $loop) {
                    if (Storage::exists($file)) {
                        return response()->download(storage_path('app/'. $file))->setCache(['no_cache' => true]);
                    } else {
                        abort(404);
                    }
                }

                $no++;
            }
        } else if ($type == 'document') {
            $update = DB::table('project_update')->where('id', $loop)->where('project_id', $project->id)->firstOrFail();
            if (Storage::exists($update->dokumen))
                return response()->download(storage_path('app/'. $update->dokumen))->setCache(['no_cache' => true]);
        }
        

        abort(404);
    }
}
