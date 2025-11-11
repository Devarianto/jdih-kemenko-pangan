<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

use Cactuar\Admin\Helpers\lang;
use Cactuar\Admin\Helpers\helper;
use Cactuar\Admin\Models\Menu;
use Cactuar\Admin\Models\Conf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

use Validator;
use recaptcha;

class Front
{
    public function handle($request, Closure $next, $guard = null)
    {
        lang::initial();
        
		$webConfig = Conf::initial('site-setting');
        if (!$webConfig) {
            echo view('errors.offline');
            die();
        }
        
        /*if (App::environment('production')) { //disabled as request, recommend redirect by htaccess / cpanel
            if (starts_with($request->header('host'), 'www.') && !$webConfig->value('use-www')) {
                $host = str_replace('www.', '', $request->header('host'));
                $request->headers->set('host', $host);
    
                return Redirect::to($request->fullUrl(), 301);
            } elseif (!starts_with($request->header('host'), 'www.') && $webConfig->value('use-www')) {
                $host = 'www.' . $request->header('host');
                $request->headers->set('host', $host);
    
                return Redirect::to($request->fullUrl(), 301);
            }
        }*/

        Validator::extend('recaptcha', function($attr, $value, $param) {
			return recaptcha::validate($value);
		});

        Validator::extend('rejectxss',function($a,$b,$c) {
            if (is_string($b) && preg_match('/(<script\b[^>]*>|<[^>]+on\w+=|javascript:|&#x[0-9a-f]+;)/i', $b)) {
                return false;
            }

            return true;
        }, 'Request rejected because contains invalid content');

        Validator::extend('custom_email', function($a, $b, $c) {
            if (is_string($b) && preg_match('/^[\w\.+-]+@([\w-]+\.)+[\w-]{2,4}$/', $b)) {
                return true;
            }

            return false;
        }, \lang::translate('validate.email-format'));

        view()->share('mainMenu', Menu::position('main'));
        view()->share('footLeftMenu', Menu::position('foot-left'));
        view()->share('footRightMenu', Menu::position('foot-right'));
        
        view()->share('webConfig', $webConfig);
		$request->attributes->add(['webConfig' => $webConfig]);
		
        if ($webConfig->status == 'offline') {
            echo view('errors.offline');
            die();
        }
        
        return $next($request);
    }
}
