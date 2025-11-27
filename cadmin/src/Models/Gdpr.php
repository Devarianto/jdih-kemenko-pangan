<?php 
namespace Cactuar\Admin\Models;

use Cookie;

class Gdpr {

    public static $alwaysOn = 'always-on';

    public static function category(){ //return array

        $category = [];

        foreach(config('cadmin.gdpr.category', []) as $k => $v){
            if($k !== self::$alwaysOn)
                $category[] = $k;
        }

        return $category;
    }

    public static function setCookie($cookieName = null, $value = true){ //return boolean
        if(!$cookieName) return false;
        
        if(!in_array($cookieName, self::category())) return false;

        $value = ($value == true) ? 'on' : 'off';

        $minutes = (int) config('cadmin.gdpr.lifetime') > 0 ? config('cadmin.gdpr.lifetime') : 60 * 24 * 30; //default minutes one month

        Cookie::queue($cookieName, $value , $minutes);

        return true;
    }

    public static function getCookie($cookieName = null){ //return boolean

        if(!config('cadmin.gdpr.enabled')) return true;

        if($cookieName == self::$alwaysOn) return true;

        if(conf('site-setting')->gdpr == 'off') return true;

        if(!Cookie::get($cookieName)) return false;

        //renew cookies
        $minutes = 60 * 24 * 30; //default minutes one month
        $value = Cookie::get($cookieName);
        Cookie::queue($cookieName, $value, $minutes);

        return $value == 'on' ? true : false;
    }

    public static function status(){ //return boolean
        //enabled from config
        if(!config('cadmin.gdpr.enabled')) return false;
        //enable/disabled from site setting
        return conf('site-setting')->gdpr == 'on' ? true : false;
    }

    public static function show(){ //return boolean
        
        if(!self::status()) return false;

        foreach(self::category() as $category){
            $cookie = Cookie::get($category);
            if(!in_array($cookie, ['on', 'off'])){
                return true;
            }
        }

        return false;
    }
}