<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'no_project',
        'name_project',
        'category_id',
        'date',
        'file',
        'applicant_name',
        'status_review',
    ];

    public function applicantDivisions()
    {
        return $this->belongsToMany(ApplicantDivision::class, 'project_applicant_division', 'project_id', 'applicant_division_id');
    }

    public function category()
    {
        return $this->belongsTo(CategoryProject::class, 'category_id', 'id')->translate();
    }
}


