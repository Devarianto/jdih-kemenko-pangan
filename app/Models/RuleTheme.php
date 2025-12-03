<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cactuar\Admin\Traits\Models\SortableTrait;

class RuleTheme extends Model
{
    use SortableTrait;
    protected $table = 'rule_themes';
}
