<?php

namespace Cactuar\Admin\Http\Controllers\AI\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use	Cactuar\Admin\Models\AI\OpenAILog;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ListingTrait;
use Cactuar\Admin\Traits\Controllers\DownloadTrait;
use Cactuar\Admin\Helpers\admin;
use Config;

class LogController extends Controller
{
    use BaseTrait, ListingTrait, DownloadTrait;
	
    public function __construct()
    {
        if (request()->query('user_id')) {
            $user = \Cactuar\Admin\Models\User::select('display_name')->findOrFail(request()->query('user_id'));
            
            $this->listingLabel = $this->label('listing').' for <b>'.e($user->display_name).'</b><div style="margin:10px 0px;"><a href="'.admin::url(admin::module()).'" class="btn btn-flat bg-blue">Clear selection</a></div>';
        }
    }
    
    public function listingRes()
    {
        $res = OpenAILog::select();
        if (request()->query('user_id'))
            $res->whereUserId(request()->query('user_id'));
        return $res;
    }
    
    public function listingFields()
    {
        return ['user_display_name' => 'Actor', 'method' => 'Method', 'path' => 'Path', 'status' => 'Status','body' => 'Body', 'response' => 'Response'];
    }
    
    public function listingOrders()
    {
        $out = $this->listingFields();
        unset($out['module']);
        if (request()->query('user_id'))
            unset($out['user_display_name']);
        return $out;
    }
	
	public function listingOrderDefault($q)
	{
		return $q->orderBy('id', 'desc');
	}
    
    public function listingSearchs()
    {
        return ['user_display_name', 'module', 'act', 'unique_label'];
    }
    
    public function listingTimes()
    {
        return ['created_at' => 'Created'];
    }
    
    public function listingRanges()
    {
        return ['created_at'];
    }
    
    public function listingCallback($key, $value, $item, $type)
    {
        if ($key == 'user_display_name' && $type == 'html' && !request()->query('user_id'))
            return '<a href="'.admin::url(admin::module().'?user_id='.$item->user_id).'">'.e($value).'</a>';
        
        if( in_array($key, ['body', 'response']))
            return '<pre style="width:250px;height:150px;overflow-y:auto;white-space: pre-wrap;">'.$value.'</pre>';
    }
}
