<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cactuar\Admin\Traits\Models\TranslateTrait;

class ApplicantDivision extends Model
{
    use TranslateTrait;
    
    protected $table = 'applicant_divisions';

    public function getDataforOptions()
    {
        return self::whereIsActive(1)->pluck('label','id')->toArray();
    }

}
