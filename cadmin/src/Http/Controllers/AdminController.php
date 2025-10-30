<?php

namespace Cactuar\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Validator;

class AdminController extends Controller
{
    public function postFilter()
    {
        $get = Request::query();
        
        $sort = explode('-', Request::input('sort'));
        
        $get['sort'] = $get['sortType'] = '';
        if (is_array($sort) && count($sort) == 2) {
            $get['sort'] = $sort[0];
            $get['sortType'] = $sort[1];
        }
		
		$get['search'] = Request::input('search');
        $get['range'] = Request::input('range');
        $get['filter'] = Request::input('filter');
        $get['page'] = 1;
        
        return redirect(implode('/', (array) json_decode(Request::input('segments'))).'?'.http_build_query($get));
    }

    public function postCkeditorUpload()
    {
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

        $post = request()->all();
        $valid = Validator::make($post,[
            'upload'=>'file|required|mimes:jpg,png,gif,webp|fileext:jpg,png,gif,webp|phpscan'
        ]);
        if ($valid->fails()) {
            return response()->json(['error'=>$valid->errors()->all()]);
        }

        if (Auth::user()->allow('image','create') !== true) {
            return response()->json(['error'=>['message'=>'forbidden access']]);
        }

        if (config('cadmin.media.driver') == 's3') {
            $file = $post['upload'];
            $fname = $file->getClientOriginalName();
            $fname = strtolower(str_replace(' ','-',preg_replace("/[^a-zA-Z0-9\/_|+ .-]/", "", $fname)));
            $path = config('cadmin.media.sourcepath').'/images/uploads';
            \Storage::disk('s3')->put($path.'/'.$fname,file_get_contents($file->getRealPath()),'public');
            return response()->json(['url'=>\Storage::disk('s3')->url($path.'/'.$fname)]);
        }

        $path = config('cadmin.media.sourcepath').'/images/uploads';
        if (!file_exists(public_path($path)))
            mkdir($path,0775,true);
        $file = $post['upload'];
        $fname = $file->getClientOriginalName();
        $fname = strtolower(str_replace(' ','-',preg_replace("/[^a-zA-Z0-9\/_|+ .-]/", "", $fname)));
        if (file_exists(public_path($path.'/'.$fname))) {
            return response()->json(['url'=>asset($path.'/'.$fname)]);
        }

        $file->move(public_path($path),$fname);

        return response()->json(['url'=>asset($path.'/'.$fname)]);
    }
}