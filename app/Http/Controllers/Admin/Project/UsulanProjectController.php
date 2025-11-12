<?php

namespace App\Http\Controllers\Admin\Project;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\DeleteTrait;
use Cactuar\Admin\Traits\Controllers\DownloadTrait;
use App\Models\Project;
use App\Models\StatusProject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UsulanProjectController extends Controller
{
    use BaseTrait, ListingTrait, DeleteTrait, DownloadTrait;

    public function listingRes()
    {
        return Project::select();
    }
    
    public function listingFields()
    {
        return [
            'no_project' => 'Nomor Project',
            'name_project' => 'Nama Project',
            'applicant_name' => 'Pemohon',
            'status_review' => 'Status Review',
            'status_project' => 'Status Project',
        ];
    }

    public function listingCallback($key,$value,$item,$type)
    {
        if($key == 'kategori'){
             return $item->getKategori['label'];
        }

        if ($key == 'status_review'){
            if ($item->status_review == 0)
                return 'Menunggu review';
            elseif($item->status_review == 1)
                return 'Reject';
            else
                return 'Approve';
        }

        if($key == 'status_project'){
            if ($item->status_project == 0)
            {
                return "Belum di Proses";
            }else{
                return optional($item->getStatus)->label ?? '-';
            }
        }

        return e($value) ?? '-';
    }

    public function listingTimes()
    {
        return ['created_at' => 'Created'];
    }

    public function listingOrders()
    {
        return ['created_at' => 'Created'];
    }

    public function listingRanges()
    {
        return ['created_at'];
    }

    public function listingOrderDefault($q)
    {
        return $q->orderBy('created_at', 'desc');
    }

    public function listingBulkAction()
	{
		$acts = [];
		$this->deleteBulkAction($acts);

		return $acts;
	}

    public function listingCustomActs($row)
    {
        return [
            '<a href="'.url()->admin($this->module().'/detail?unique='.$row->id).'" 
            class="btn btn-primary btn-flat btn-sm detail-view"><i class="fa fa-file"></i> Detail</a>'
        ];
    }
	
	public function formRes()
	{
	    return new Project;
	}

    public function getDetail(Request $request)
    {
        if (request()->queryValidated('unique','numeric|required')) {
            $data = Project::findOrFail(request()->query('unique'));
            $updates = DB::table('project_update')
                ->where('project_id', $data->id)
                ->orderBy('created_at', 'asc')
                ->get();
            $statuses = StatusProject::translate()
                ->where('status_projects.is_active', 1)
                ->where('status_projects.id', '!=', 1)
                ->orderBy('status_projects.id', 'asc')
                ->get(['status_projects.id', 'status_projects_lang.label']);

            $compact=[
                'data' => $data,
                'updates' => $updates,
                'statuses' => $statuses,
            ];

            return view('admin.project.detail',$compact);
        }
    }

    public function postApprove(Request $request)
    {
        $validated = $request->validate([
            'unique' => 'required|numeric',
            'end_date' => 'required|date',
        ]);

        $project = Project::findOrFail($validated['unique']);
        if ((int) $project->status_review !== 0) {
            return back()->with('error', 'Aksi tidak diizinkan. Usulan sudah direview.');
        }
        $project->status_review = 2;
        $project->end_date = \Carbon\Carbon::parse($validated['end_date'])->format('Y-m-d');
        $project->save();

        // insert initial status to project_update table
        $firstStatus = StatusProject::whereIsActive(1)->orderBy('id', 'asc')->first();

        $project->status_review = 2;
        $project->status_project = $firstStatus->id;
        $project->save();
        if ($firstStatus) {
            DB::table('project_update')->insert([
                'user_id' => Auth::id(),
                'project_id' => $project->id,
                'project_name' => $project->name_project,
                'id_status_project' => $firstStatus->id,
                'label_status_project_id' => $firstStatus->translated('label', 'id'),
                'label_status_project_en' => $firstStatus->translated('label', 'en'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Usulan berhasil di-approve.');
    }

    public function postReject(Request $request)
    {
        $validated = $request->validate([
            'unique' => 'required|numeric',
        ]);

        $project = Project::findOrFail($validated['unique']);
        if ((int) $project->status_review !== 0) {
            return back()->with('error', 'Aksi tidak diizinkan. Usulan sudah direview.');
        }
        $project->status_review = 1;
        $project->save();

        DB::table('project_update')->insert([
            'user_id' => Auth::id(),
            'project_id' => $project->id,
            'project_name' => $project->name_project,
            'id_status_project' => 0,
            'label_status_project_id' => 'Tolak',
            'label_status_project_en' => 'Reject',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Usulan berhasil di-reject.');
    }

    public function postUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|numeric|exists:projects,id',
            'status_project_id' => 'required|numeric|exists:status_projects,id|not_in:1',
            'file' => 'nullable|file|max:10240',
            'keterangan' => 'nullable|string',
        ]);

        $project = Project::findOrFail($validated['project_id']);

        // optional file upload
        $dokumenPath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time().'_'.preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $folder = Str::slug($project->no_project);
            $targetDir = public_path('uploads/projects/'.$folder);
            if (!is_dir($targetDir)) {
                @mkdir($targetDir, 0775, true);
            }
            $file->move($targetDir, $filename);
            $dokumenPath = 'uploads/projects/'.$folder.'/'.$filename;
        }

        // get translated labels for selected status
        $status = StatusProject::findOrFail($validated['status_project_id']);
        $labelId = $status->translated('label', 'id');
        $labelEn = $status->translated('label', 'en');

        // update main project's current status_project id
        $project->status_project = (int) $status->id;
        $project->save();

        DB::table('project_update')->insert([
            'user_id' => Auth::id(),
            'project_id' => $project->id,
            'project_name' => $project->name_project,
            'id_status_project' => $status->id,
            'label_status_project_id' => $labelId,
            'label_status_project_en' => $labelEn,
            'dokumen' => $dokumenPath,
            'note' => $validated['keterangan'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Status project berhasil ditambahkan.');
    }
}
