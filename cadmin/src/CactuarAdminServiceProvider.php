<?php namespace Cactuar\Admin;

//VERSION 1.2.0

use Illuminate\Support\ServiceProvider;
use Cactuar\Admin\Helpers\admin;
use Cactuar\Admin\Helpers\lang;
use Cactuar\Admin\Helpers\media;
use Cactuar\Admin\Models\Permalink;
use Validator;
use Request;
use URL;
use Illuminate\Foundation\AliasLoader;

class CactuarAdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
		
        //
		$this->loadViewsFrom(__DIR__.'/views', 'cactuar');
        
		$this->app->singleton(
			'Illuminate\Contracts\Http\Kernel',
            'Cactuar\Admin\Http\Kernel'
        );
		
		$this->publishes([
			__DIR__.'/Publish/Controllers' => base_path('app/Http/Controllers/Admin'),
        ], 'cadmin-controller');
        
        $this->publishes([
            __DIR__.'/Publish/Public' => base_path('public'),
        ], 'cadmin-admin-asset');
        
        $this->publishes([
            __DIR__.'/Publish/Middleware' => base_path('app/Http/Middleware'),
		], 'cadmin-middleware');
        
        $this->publishes([
            __DIR__.'/Publish/Views' => base_path('resources/views'),
        ], 'cadmin-view');
        
		$this->publishes([
            __DIR__.'/Publish/Lang' => base_path('resources/lang'),
        ], 'cadmin-lang');
        
        $this->publishes([
        	__DIR__.'/Publish/Config' => base_path('config/cadmin'),
		], 'cadmin-config');
        
        $this->publishes([
           __DIR__.'/Publish/Migrations' => base_path('database/migrations'),
        ], 'cadmin-migration');
        
        $this->publishes([
            __DIR__.'/Publish/Exception' => base_path('app/Exceptions'),
        ], 'cadmin-exception');

        $this->publishes([
            __DIR__.'/Publish/Block' => base_path('app'),
        ], 'webarq-block');
        
        //Macros
        Request::macro('validated',function($k,$rule='string|numeric',$die=false) {
            $var = request()->get($k);
            
            if (!$rule)
                return $var;

            if ($rule === 'string|numeric') {
                if (is_string($var) || is_numeric($var)) {
                    return $var;
                }
                if ($die == true)
                    abort(404);
                return null;
            }
            
            if (\Validator::make(['var' => $var],['var' => $rule])->fails() == true) {
                if ($die == true)
                    abort(404);
                return null;
            }
            
            return $var;
        });
        
        Request::macro('queryValidated',function($k,$rule='string|numeric',$die=false) {
            $var = request()->get($k);
            
            if (!$rule)
                return $var;

            if ($rule === 'string|numeric') {
                if (is_string($var) || is_numeric($var)) {
                    return $var;
                }
                if ($die == true)
                    abort(404);
                return null;
            }
            
            if (\Validator::make(['var' => $var],['var' => $rule])->fails() == true) {
                if ($die == true)
                    abort(404);
                return null;
            }
            
            return $var;
        });
        
        URL::macro('admin',function($target) {
            return admin::url($target);
        });
        
        URL::macro('lang',function($lang) {
            return lang::urlChange($lang);
        });
        
        URL::macro('translated',function($permalink) {
            return lang::url($permalink); 
        });
        
        URL::macro('media',function($path) {
            return media::url($path); 
        });
		
		URL::macro('convert',function($path,$ext) {
			return media::convert($path,$ext);
		});
        
        URL::macro('thumb',function($path,$key) {
            return media::thumb($path,$key); 
        });
		
		URL::macro('real',function($target) {
			foreach (['http://','https://','//'] as $v)
				if (substr(strtolower($target),0,strlen($v)) == $v)
					return $target;
				
			return url($target);
		});
		
		URL::macro('target',function($target) {
			foreach (['http://','https://','//'] as $v)
				if (substr(strtolower($target),0,strlen($v)) == $v)
					return '_blank';
			return '_self';
		});
		
		URL::macro('permalink',function($module,$uniqid,$lang = null) {
			return Permalink::permalink($module,$uniqid,$lang);
		});
        
        $this->commands([
            \Cactuar\Admin\Console\Recipe\Cook::class,
            \Cactuar\Admin\Console\Recipe\Cloner::class,
            \Cactuar\Admin\Console\Recipe\Creator::class,
        ]);

        Validator::extend('fileext',function($a,$b,$c) {
            if (!is_object($b))
                return false;
            if (in_array(strtolower($b->getClientOriginalExtension()),['php','sh']))
                return false;
            
            foreach($c as $x) {
                if (strtolower($b->getClientOriginalExtension()) === strtolower($x))
                    return true;
            }

            return false;
        }, 'Invalid file format');

        Validator::extend('phpscan',function($a,$b,$c) {
            if (!is_object($b))
                return false;
            $content = strtolower(file_get_contents($b->path()));
            if (strpos($content, '<?php') !== false)
                return false;
            return true;
        }, 'Malicious files!');
		
        include_once(__DIR__.'/helpers.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {	
		$loader = AliasLoader::getInstance();

        // Add your aliases
        $loader->alias('media', \Cactuar\Admin\Helpers\media::class);
        $loader->alias('og', \Cactuar\Admin\Helpers\og::class);
        $loader->alias('lang', \Cactuar\Admin\Helpers\lang::class);
        $loader->alias('recaptcha', \Cactuar\Admin\Helpers\recaptcha::class);
        $loader->alias('helper', \Cactuar\Admin\Helpers\helper::class);
        $loader->alias('admin', \Cactuar\Admin\Helpers\admin::class);
        $loader->alias('minify', \Cactuar\Admin\Helpers\minify::class);
        $loader->alias('og', \Cactuar\Admin\Helpers\og::class);
        $loader->alias('og', \Cactuar\Admin\Helpers\og::class);
        $loader->alias('Form', \Cactuar\Admin\Helpers\form::class);
		
        include_once __DIR__.'/Http/routes.php';
	}
}
