<?php namespace Cactuar\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Cactuar\Admin\Models\User;

class Log extends Model
{
    protected $table = 'logs';
    
    public static function write($module, $act, $unique = null, $uniqueLabel = null)
    {
        $limit255 = static function ($value) {
            return is_null($value) ? null : mb_substr((string) $value, 0, 255);
        };

        $res = new Log();
        $res->user_id = Auth::user()->id;
        $res->username = $limit255(Auth::user()->name);
        $res->user_display_name = $limit255(Auth::user()->display_name);
        $res->module = $limit255($module);
        $res->act = $limit255($act);
        $res->unique_id = $limit255($unique);
        $res->unique_label = $limit255($uniqueLabel);
        $res->post = json_encode(self::postData());
        
        $res->save();
    }
    
    public static function postData()
    {
        $post = \Request::except('_token');
        
        foreach ($post AS $key => &$val) {
			if (in_array($key, array('password', 'old_pass')))
				$val = '';
				
            if (!is_array($val)) {
                $val = \Str::limit($val, 50);
            }
        }
        
        return $post;
    }
}
