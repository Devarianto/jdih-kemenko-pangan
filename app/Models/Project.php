<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'user_id',
        'no_project',
        'name_project',
        'category_id',
        'date',
        'file',
        'applicant_name',
        'status_review',
        'status_project',
        'end_date',
    ];

    public function scopeAuthUser(Builder $query): void
    {
        $query->where('user_id', \Auth::guard('account')->user()->id);
    }

    public function applicantDivisions()
    {
        return $this->belongsToMany(ApplicantDivision::class, 'project_applicant_division', 'project_id', 'applicant_division_id')->select('label')->translate();
    }

    public function applicantDivisionsStore()
    {
        return $this->belongsToMany(ApplicantDivision::class, 'project_applicant_division', 'project_id', 'applicant_division_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryProject::class, 'category_id', 'id')->translate();
    }

    public function getStatus()
    {
        return $this->belongsTo(StatusProject::class, 'status_project', 'id')->translate();
    }
}


