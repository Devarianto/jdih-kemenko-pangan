<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Cactuar\Admin\Helpers\helper;

use Cactuar\Admin\Models\Menu;
use Cactuar\Admin\Models\Permalink;

use App\Models\Gallery;
use App\Models\News;
use App\Models\Project;
use App\Models\ProjectApplicantDivision;
use App\Models\CategoryProject;
use App\Models\ApplicantDivision;
use Carbon\Carbon;
use lang;
use DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('category')->authUser()->whereIn('status_review', [0,1]);

        if ($request->filled('q')) {
            $query->where('name_project', 'like', '%' . $request->input('q') . '%');
        }

        if ($request->filled('year')) {
            $query->where('date', 'like', $request->input('year') . '%');
        }

        $projects = $query->orderBy('created_at','desc')->paginate(10);
        $years = Project::selectRaw('LEFT(`date`, 4) as year')
            ->authUser()
            ->whereNotNull('date')
            ->where('date', '!=', '')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('dynamic.pages.dashboard', compact('projects', 'years'));
    }

    public function formUsulan()
    {
        $categories = CategoryProject::translate()->whereIsActive(1)->pluck('label','id');
        $applicantDivisions = ApplicantDivision::translate()->whereIsActive(1)->pluck('label','id');
        return view('dynamic.pages.dashboard-formulir-usulan', compact('categories','applicantDivisions'));

    }


    public function detailUsulan($id)
    {
        try {
            $realId = Crypt::decryptString($id);
        } catch (\Throwable $e) {
            abort(404);
        }

        $project = Project::with(['category','applicantDivisions'])->authUser()->findOrFail($realId);

        $rejected = DB::table('project_update')
            ->where('project_id', $project->id)
            ->where('id_status_project', 0)
            ->first();

        $updates = [];

        $updates ['review'] = [
            'label' => lang::translate('dashboard.status.review'),
            'date' => $project->created_at
        ];

        if ($rejected != null) {
            $updates['rejected'] = [
                'label' => lang::translate('dashboard.status.rejected'),
                'date' => $project->created_at
            ];
        }

        
        return view('dynamic.pages.dashboard-usulan-detail', compact('project', 'updates'));

    }


    public function listProject(Request $request)
    {
        $query = Project::with(['category','getStatus'])->authUser()->where('status_review', 2);

        if ($request->filled('q')) {
            $query->where('name_project', 'like', '%' . $request->input('q') . '%');
        }

        if ($request->filled('year')) {
            $query->where('date', 'like', $request->input('year') . '%');
        }

        $projects = $query->orderBy('created_at','desc')->paginate(10);

        $years = Project::selectRaw('LEFT(`date`, 4) as year')
            ->authUser()
            ->where('status_review', 2)
            ->whereNotNull('date')
            ->where('date', '!=', '')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('dynamic.pages.dashboard-project', compact('projects','years'));

    }

    public function detailProject($id)
    {
        try {
            $realId = \Illuminate\Support\Facades\Crypt::decryptString($id);
        } catch (\Throwable $e) {
            abort(404);
        }

        $project = Project::with(['category','applicantDivisions'])->authUser()->findOrFail($realId);
        $updates = \DB::table('project_update')
            ->where('project_id', $project->id)
            ->orderBy('created_at', 'asc')
            ->get();
        return view('dynamic.pages.dashboard-detail-project', compact('project','updates'));

    }

    /**
     * Store a new project submission.
     */
    public function storeProject(Request $request)
    {
        $validated = $request->validate([
            'name_project' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer'],
            'date' => ['required', 'string', 'date_format:d/m/Y'],
            'files' => ['required', 'array', 'min:1', 'max:3'],
            'files.*' => ['file', 'mimes:jpg,jpeg,png,webp,pdf,doc,docx', 'max:5120'],
            'applicant_name' => ['required', 'string', 'max:255'],
            'applicant_divisions' => ['nullable', 'array'],
            'applicant_divisions.*' => ['integer'],
        ]);
        
        // Generate unique no_project
        $noProject = $this->generateNoProject();

        $storedPaths = [];
        $storagePath = 'upload/projects';

        foreach ($request->file('files', []) as $uploadedFile) {
            if ($uploadedFile) {
                // Buat nama unik
                $uniqueName = Str::uuid()->toString() . '.' . $uploadedFile->getClientOriginalExtension();

                // Simpan ke storage
                Storage::disk('local')->putFileAs(
                    $storagePath,
                    $uploadedFile,
                    $uniqueName
                );

                // Simpan path untuk database
                $storedPaths[] = $storagePath . '/' . $uniqueName;
            }
        }
        $project = Project::create([
            'user_id' => Auth::guard('account')->id(),
            'no_project' => $noProject,
            'name_project' => $validated['name_project'],
            'category_id' => $validated['category_id'],
            'date' => Carbon::createFromFormat('d/m/Y', $validated['date'])->format('Y-m-d'),
            'file' => json_encode($storedPaths),
            'applicant_name' => $validated['applicant_name'],
            'status_review' => 0,
        ]);

        $project->applicantDivisionsStore()->sync($request->input('applicant_divisions', []));

        return redirect()->route('dashboard')->with('status', 'Usulan project berhasil disimpan.');
    }

    protected function generateNoProject(): string
    {
        do {
            $candidate = 'PRJ-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Project::where('no_project', $candidate)->exists());
        return $candidate;
    }

}
