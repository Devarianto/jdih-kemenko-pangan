<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cactuar\Admin\Traits\Models\TranslateTrait;

class CategoryProject extends Model
{
    use TranslateTrait;
    
    protected $table = 'category_project';

    public function getDataforOptions()
    {
        return self::whereIsActive(1)->pluck('label','id')->toArray();
    }

}
