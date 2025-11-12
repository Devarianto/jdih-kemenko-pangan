<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cactuar\Admin\Traits\Models\TranslateTrait;
use Cactuar\Admin\Traits\Models\SortableTrait;

class StatusProject extends Model
{
    use TranslateTrait,SortableTrait;
    
    protected $table = 'status_projects';

    public function getDataforOptions()
    {
        return self::whereIsActive(1)->pluck('label','id')->toArray();
    }

}
