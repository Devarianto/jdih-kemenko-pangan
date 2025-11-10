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
use App\Models\CategoryProject;
use App\Models\ApplicantDivision;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $query = Project::with('category');

        if ($request->filled('q')) {
            $query->where('name_project', 'like', '%' . $request->input('q') . '%');
        }

        if ($request->filled('year')) {
            $query->where('date', 'like', $request->input('year') . '%');
        }

        $projects = $query->orderBy('created_at','desc')->paginate(10);
        $years = Project::selectRaw('LEFT(`date`, 4) as year')
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

        $project = Project::with(['category','applicantDivisions'])->findOrFail($realId);
        return view('dynamic.pages.dashboard-usulan-detail', compact('project'));

    }


    public function listProject(Request $request)
    {
        $query = Project::with('category')->where('status_review', 1);

        $projects = $query->orderBy('created_at','desc')->paginate(10);

        return view('dynamic.pages.dashboard-project', compact('projects'));

    }

    public function detailProject()
    {
        return view('dynamic.pages.dashboard-detail-project');

    }

    /**
     * Store a new project submission.
     */
    public function storeProject(Request $request)
    {
        $validated = $request->validate([
            'no_project' => ['required', 'string', 'max:255'],
            'name_project' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer'],
            'date' => ['required', 'string', 'max:255'],
            'files' => ['required', 'array', 'min:1'],
            'files.*' => ['file', 'mimes:jpg,jpeg,png,webp,pdf,doc,docx', 'max:5120'],
            'applicant_name' => ['required', 'string', 'max:255'],
            'applicant_divisions' => ['nullable', 'array'],
            'applicant_divisions.*' => ['integer'],
        ]);

        $storedPaths = [];
        foreach ($request->file('files', []) as $uploadedFile) {
            if ($uploadedFile) {
                $storedPaths[] = $uploadedFile->store('projects', 'public');
            }
        }

        $project = Project::create([
            'no_project' => $validated['no_project'],
            'name_project' => $validated['name_project'],
            'category_id' => $validated['category_id'],
            'date' => Carbon::parse($validated['date'])->format('Y-m-d'),
            'file' => json_encode($storedPaths),
            'applicant_name' => $validated['applicant_name'],
            'status_review' => 0,
        ]);

        $project->applicantDivisions()->sync($request->input('applicant_divisions', []));

        return redirect()->route('dashboard')->with('status', 'Usulan project berhasil disimpan.');
    }

}
