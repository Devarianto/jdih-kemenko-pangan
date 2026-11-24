<?php namespace Cactuar\Admin\Helpers;

use Validator;
use Intervention\Image\ImageManagerStatic as Image;

//composer require league/flysystem-aws-s3-v3

class cfinds3
{
    protected $params = [];

    public static function install($conf) {
		return new cfinds3($conf);
	}

    private function driver()
    {
        return \Storage::disk('s3');
    }

	public function __construct($conf)
    {
        //define base config
        $params = [];
        $params['files'] = [];
        $params['dirs'] = [];
        $params['whitelists'] = [];
        $params['basepath'] = config('cadmin.media.sourcepath');
        $params['baseurl'] = trim($this->driver()->url(''),'/');
        
        foreach($conf['types'] as $k=>$v) {
            $params['root'] = ['name'=>$k,'ext'=>$v['ext']];
        }

        $params['buttons'] = ['create-folder','upload-file','delete-folder','delete-file','up','search'];
        if (request()->get('search')) {
            $params['buttons'] = array_diff($params['buttons'],['create-folder','upload-file','delete-folder','up']);
        }
        if (array_get($conf,'disable.add')) {
            $params['buttons'] = array_diff($params['buttons'],['create-folder','upload-file']);
        }
        if (array_get($conf,'disable.delete')) {
            $params['buttons'] = array_diff($params['buttons'],['delete-folder','delete-file']);
        }

        $params['view']  = request()->get('opener') ? 'cactuar::admin.cfind-opener' : 'cactuar::admin.cfind';
        
        $params['resize'] = [
            'avail'=>false,
            'type'=>'',
            'width'=>0,
            'height'=>0,
        ];

        if (request()->validated('ext','string|required')) {
            $params['whitelists'] = explode(',',strtolower(request()->get('ext')));
        }

        if (request()->get('thumb')) {
            foreach(config('cadmin.media.thumbs') ?: [] as $k=>$v) {
                if ($k == request()->get('thumb')) {
                    $params['resize']['avail'] = true;
                    $params['resize']['type'] = array_get($v,'type') ?: 'cover';
                    $params['resize']['width'] = (double) array_get($v,'width') ?: 0;
                    $params['resize']['height'] = (double) array_get($v,'height') ?: 0;
                    
                    if (!empty($params['whitelists'])) {
                        foreach($params['whitelists'] as $k=>$v) {
                            if (!in_array($v,['png','jpg','jpeg','gif','bmp','webp'])) {
                                unset($params['whitelists'][$k]);
                            }
                        }
                    } else {
                        $params['whitelists'] = ['png','jpg','jpeg','gif','bmp','webp'];
                    }
                }
            }
        }

        $this->params = $params;
        $this->params['tree'] = $this->readPath($params['root']['name']);
        
        $path = null;
        if (request()->get('path')) {
            foreach($this->params['paths'] as $v) {
                if ($v['token'] == request()->get('path')) {
                    $path = $v;
                }
            }
        }
        if (!$path) {
            $root = $this->params['tree'];
            unset($root['childs']);
            $path = $root;
        }
        $this->params['path'] = $path;
        
        if ($this->params['path']['token'] == $this->params['tree']['token']) {
            $this->params['buttons'] = array_diff($this->params['buttons'],['up','delete-folder']);
        }

    }

    public function draw()
    {   
        if (strtolower(request()->method()) == 'post') {
            if (request()->get('act') == 'create-folder') {
                return $this->postCreateFolder();
            }
            if (request()->get('act') == 'delete-folder') {
                return $this->postDeleteFolder();
            }
            if (request()->get('act') == 'upload-file') {
                return $this->postUploadFile();
            }
            if (request()->get('act') == 'delete-file') {
                return $this->postDeleteFile();
            }
            if (request()->get('act') == 'use') {
                return $this->postUse();
            }
            if (request()->get('act') == 'auto-resize') {
                return $this->postAutoResize();
            }
            if (request()->get('act') == 'custom-resize') {
                return $this->postCustomResize();
            }
            abort(404);
        }

        $this->readFiles();

        usort($this->params['files'],function($a,$b) { return $b['name'] < $a['name']; });
		usort($this->params['dirs'],function($a,$b) { return $b['name'] < $a['name']; });

        return view($this->params['view'],$this->params);
    }

    private function readFiles()
    {
        if (request()->query('search')) {
            return;
        }
        $path = $this->params['path']['path'];
        foreach($this->driver()->files($path) as $f) {
            if ($f == '.' || $f == '..' || $f == 'index.html') {
                continue;
            }

            $ext = strtolower(pathinfo($path.'/'.$f, PATHINFO_EXTENSION));
            if (!in_array($ext,$this->params['root']['ext'])) {
                //go to quarantine
                continue;
            }

            $this->itemFile($f,$this->params['path']);
        }

        foreach($this->driver()->directories($path) as $f) {
            $this->itemDir($f,$this->params['path']);
        }
    }   

    private function readPath($path,$back='')
    {
        $v = [
                'name'=>$path,
                'path'=>$this->params['basepath'].'/'.$path,
                'token'=>$this->token($path),
                'back'=>$back,
            ];
        
        if (!array_key_exists('paths',$this->params)) {
            $this->params['paths'] = [];
        }

        $this->params['paths'][] = $v;

        $v['childs'] = [];    

        foreach($this->driver()->directories($this->params['basepath'].'/'.$path) as $i) {
            $f = $this->realName($i);
            if (strpos(' '.strtolower($f),strtolower(request()->query('search'))) >= 1) {
                $this->itemDir($f,$v);
            }
            $v['childs'][] = $this->readPath($path.'/'.$f,$v['token']);
        }

        if (request()->queryValidated('search','string|required')) {
            foreach($this->driver()->files($this->params['basepath'].'/'.$path) as $i) {
                $f = $this->realName($i);
                if (strpos(' '.strtolower($f),strtolower(request()->query('search'))) >= 1) {
                    $this->itemFile($f,$v);
                }
            }
        }
        return $v;
    }

    private function token($str)
    {
        return hash("sha512", $str . '-disini-ada-cactuar');
    }

    private function itemDir($name,$path)
    {
        $name = $this->realName($name);
        $this->params['dirs'][] = [
            'name'=>$name,
            'token'=>$this->token($path['name'].'/'.$name),
            'time'=>0,
        ];
    }

    private function itemFile($name,$path)
    {
        $name = $this->realName($name);
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        if (!empty($this->params['whitelists']) && !in_array($ext,$this->params['whitelists'])) {
            return;
        }
        
        $file = [
            'type'=>$ext,
            'path'=>$path['name'],
            'path-token'=>$path['token'],
            'name'=>$name,
            'size'=>$this->driver()->size($path['path'].'/'.$name),
            'time'=>$this->driver()->lastModified($path['path'].'/'.$name),
            'url'=>$this->params['baseurl'].'/'.$path['path'].'/'.$name,
            'image'=>false,
            'dimension'=>[
                'width'=>0,
                'height'=>0,
            ],
        ];
        
        if (in_array($ext,['jpg', 'jpeg', 'png', 'bmp', 'gif', 'ico','webp','svg'])) {
           try {
                $img = Image::make($this->driver()->get($path['path'].'/'.$name));
				$file['dimension']['width'] = $img->width();
                $file['dimension']['height'] = $img->height();
            } catch(\Exception $e) { }
            $file['image'] = true;
        }

        $file['readable'] = [
            'size'=>$this->mbsize($file['size']),
            'time'=>date('d F Y H:i',$file['time']),
        ];

        $this->params['files'][] = $file;
    }

    private function mbsize($v) {
        $bytes = (double) $v;
        
        if ($bytes > 0) {
            $unit = intval(log($bytes, 1024));
            $units = array('B', 'KB', 'MB', 'GB');

            if (array_key_exists($unit, $units) === true) {
                return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
            }
        }

        return $bytes;
    }

    private function postCreateFolder()
    {
        if (!in_array('create-folder',$this->params['buttons'])) {
            abort(404);
        }

        $post = request()->all();
        $valid = Validator($post,['folder'=>'string|required|max:255']);
        if ($valid->fails()) {
            return redirect()->back()->with('cfind-error',$valid->errors()->all());
        }

        $folder = strtolower(str_replace(' ', '-', $post['folder']));
        $folder = preg_replace("/[^a-z0-9_-]+/i", "", $folder);
        
        $this->driver()->makeDirectory($this->params['path']['path'].'/'.$folder);

        return redirect()->back()->with('cfind-success',['folder ['.$folder.'] has been created']);
    }

    private function postDeleteFolder()
    {
        if (!in_array('delete-folder',$this->params['buttons'])) {
            abort(404);
        }

        if ($this->params['path']['token'] == $this->params['tree']['token']) {
            return redirect()->back()->with('cfind-error',['cannot delete root folder']);
        }

        $this->driver()->deleteDirectory($this->params['path']['path']);
        return redirect()->back()->with('cfind-success',['folder '.$this->params['path']['name'].' has been deleted']);
    }

    private function postUploadFile()
    {
        function sanitize($name)
        {
            return strtolower(str_replace(' ','-',preg_replace("/[^a-zA-Z0-9\/_|+ .-]/", "", $name)));
        }

        $post = request()->all();
        $files = [];
        for ($i=1;$i<=5;$i++) {
            if (!array_get($post,'name_'.$i)) {
                continue;
            }

            $files[] = $post['name_'.$i];
        }

        if (count($files) <= 0) {
            return redirect()->back()->with('cfind-error',['no file to upload']);
        }

        foreach($files as $file) {
            $rules = 'required|file|max:2000|mimes:'.implode(',',$this->params['root']['ext']).'|fileext:'.implode(',',$this->params['root']['ext']).'|phpscan';
            $valid = Validator::make(['file'=>$file],['file'=>$rules]);
            if ($valid->fails()) {
                return redirect()->back()->with('cfind-error',$valid->errors()->all());
            }
            $name = sanitize($file->getClientOriginalName());
            if ($this->driver()->exists($this->params['path']['path'].'/'.$name) && !array_get($post,'overide')) {
                return redirect()->back()->with('cfind-error',['file ['.$name.'] already exists']);
            }
        }

        foreach($files as $file) {
            $this->driver()->put($this->params['path']['path'].'/'.sanitize($file->getClientOriginalName()),file_get_contents($file->getRealPath()),'public');
        }

        return redirect()->back()->with('cfind-success',['success upload '.count($files).' file(s)']);
    }

    private function postDeleteFile()
    {
        if (!request()->validated('file','string|required')) {
            return redirect()->back()->with('cfind-error',['no file to delete']);
        }

        $ext = strtolower(pathinfo(request()->get('file'),PATHINFO_EXTENSION));
        if (!in_array($ext,$this->params['root']['ext'])) {
            return redirect()->back()->with('cfind-error',['invalid file type']);
        }

        foreach($this->driver()->files($this->params['path']['path']) as $i) {
            $f = $this->realName($i);
            if ($f === request()->get('file')) {
                $this->driver()->delete($this->params['path']['path'].'/'.$f);
                return redirect()->back()->with('cfind-success',['file ['.$f.'] has been deleted']);
            }
        }
        closedir($res);

        return redirect()->back()->with('cfind-error',['file not found']);
    }

    private function postUse()
    {
        if (!request()->validated('file','string|required')) {
            return redirect()->back()->with('cfind-error',['no file to delete']);
        }

        $ext = strtolower(pathinfo(request()->get('file'),PATHINFO_EXTENSION));
        if (!in_array($ext,$this->params['root']['ext'])) {
            return redirect()->back()->with('cfind-error',['invalid file type']);
        }


        foreach($this->driver()->files($this->params['path']['path']) as $i) {
            $f = $this->realName($i);

            if ($f === request()->get('file')) {
                if (request()->validated('convert','string|required') 
                    && in_array(request()->get('convert'),$this->params['root']['ext'])
                    && $ext != request()->get('convert')
                    ) {
                    $nf = $f . '.' . request()->get('convert');

                    if ($this->driver()->exists($this->params['path']['path'].'/'.$nf)) {
                        return $this->set($this->params['path']['path'],$nf);
                    }
                    
                    $img = Image::make($this->driver()->get($this->params['path']['path'].'/'.$f));
                    $this->driver()->put($this->params['path']['path'].'/'.$nf,$img->stream(),'public');

                    return $this->set($this->params['path']['path'],$nf);
                }

                return $this->set($this->params['path']['path'],$f);
            }
        }
        closedir($res);

        return redirect()->back()->with('cfind-error',['file not found']);
    }

    private function postAutoResize()
    {
        if ($this->params['resize']['avail'] != true) {
            return redirect()->back()->with('cfind-error',['resize type not found']);
        }

        $file = request()->validated('file','string|required');
        if (!$file) {
            return redirect()->back()->with('cfind-error',['no file to resize']);
        }   

        $ext = strtolower(pathinfo($file,PATHINFO_EXTENSION));
        if (!in_array($ext,['jpg','jpeg','png','bmp','gif','webp'])) {
            return redirect()->back()->with('cfind-error',['file not supported for resize']);
        }
        if (!in_array($ext,$this->params['root']['ext'])) {
            return redirect()->back()->with('cfind-error',['file not found']);
        }


        foreach($this->driver()->files($this->params['path']['path']) as $i) {
            $f = $this->realName($i);
            if ($f == '.' || $f == '..') {
                continue;
            }

            if ($f == $file) {
                $newpath = config('cadmin.media.thumbpath').'/'.$this->params['path']['name'];
                $newfullpath = $newpath;
                $newfile = $this->params['resize']['type'].'_';
                if ($this->params['resize']['width'] > 0) {
                    $newfile .= $this->params['resize']['width'].'_';
                }   
                if ($this->params['resize']['height'] > 0) {
                    $newfile .= $this->params['resize']['height'].'_';
                }
                $newfile .= $f;

                $img = Image::make($this->driver()->get($this->params['path']['path'].'/'.$f));
                if (request()->validated('convert','string|required') && in_array(request()->get('convert'),$this->params['root']['ext'])) {
                    $newfile .= '.' . request()->get('convert');
                    $img->encode(strtolower(request()->get('convert')),100);
                }
                
                $width = (int) $this->params['resize']['width'];
                $height = (int) $this->params['resize']['height'];
                $type = $this->params['resize']['type'];

                if ($width <= 0) {
                    $img->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $this->driver()->put($newfullpath.'/'.$newfile,$img->stream(),'public');
                    return $this->set($newpath,$newfile);
                }
                if ($height <= 0) {
                    $img->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $this->driver()->put($newfullpath.'/'.$newfile,$img->stream(),'public');
                    return $this->set($newpath,$newfile);
                }

                if ($width >= 1 && $height >= 1) {
                    if ($type == 'cover') {
                        $img->fit($width, $height);
                        $this->driver()->put($newfullpath.'/'.$newfile,$img->stream(),'public');
                        return $this->set($newpath,$newfile);
                    }
                    if ($type == 'contain') {
                        if ($img->height() > $img->width()) {
                            if ($img->height() > $height) {
                                $img->resize(null, $height, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            }
                            if ($img->width() > $width) {
                                $img->resize($width, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            }
                        } else {
                            if ($img->width() > $width) {
                                $img->resize($width, null, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            }
                            if ($img->height() > $height) {
                                $img->resize(null, $height, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                            }
                        }
                        $canvas = Image::canvas($width, $height);
                        $canvas->insert($img, 'center');
                        
                        $this->driver()->put($newfullpath.'/'.$newfile,$canvas->stream(),'public');
                        return $this->set($newpath,$newfile);
                    }
                }
            }
        }   
        
        abort(404);
    }

    private function postCustomResize()
    {
        $post = request()->all();
        $valid = Validator::make($post,[
            'width'=>'numeric|required',
            'height'=>'numeric|required',
            'x1'=>'numeric|required',
            'y1'=>'numeric|required',
            'file'=>'string|required',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->with('cfind-error',$valid->errors()->all());
        }   

        if ($this->params['resize']['avail'] != true) {
            return redirect()->back()->with('cfind-error',['resize type not found']);
        }

        $file = request()->validated('file','string|required');
        $ext = strtolower(pathinfo($file,PATHINFO_EXTENSION));
        if (!in_array($ext,['jpg','jpeg','png','bmp','gif','webp'])) {
            return redirect()->back()->with('cfind-error',['file not supported for resize']);
        }
        if (!in_array($ext,$this->params['root']['ext'])) {
            return redirect()->back()->with('cfind-error',['file not found']);
        }
        
        $width = (int) $this->params['resize']['width'];
        $height = (int) $this->params['resize']['height'];
        $type = $this->params['resize']['type'];
        $towidth = (int) $post['width'];
        $toheight = (int) $post['height'];
        $x = $post['x1'];
        $y = $post['y1'];

        if ($width <= 0 || $height <= 0 || $type != 'cover') {
            return redirect()->back()->with('cfind-error',['invalid resize request']);
        }

        if (round($width/$height) != round($towidth/$toheight)) {
            return redirect()->back()->with('cfind-erroro',['invalid ratio']);
        }

        foreach($this->driver()->files($this->params['path']['path']) as $i) {
            $f = $this->realName($i);

            if ($f == $file) {
                
                $newpath = config('cadmin.media.thumbpath').'/'.$this->params['path']['name'];
                $newfullpath = $newpath;
                $newfile = $type.'_'.$width.'x'.$height.'_'.$towidth.'x'.$toheight.'_'.$x.'-'.$y.'_'.$f;
                
                $img = Image::make($this->driver()->get($this->params['path']['path'].'/'.$f));
                
                if (request()->validated('convert','string|required') && in_array(request()->get('convert'),$this->params['root']['ext'])) {
                    $newfile .= '.' . request()->get('convert');
                    $img->encode(strtolower(request()->get('convert')));
                }

                $img->crop($towidth, $toheight, $x, $y);
                $img->resize($width, $height);
                //$img->save($newfullpath.'/'.$newfile,80);
                $this->driver()->put($newfullpath.'/'.$newfile,$img->stream(),'public');
                return $this->set($newpath,$newfile);
            }
        }

        abort(404);
    }

    private function set($path,$file)
    {
        $fpath = $path.'/'.$file;
        $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        $json = [
            'path'=>$path . '/' . $file,
            'name'=>$file,
            'ext'=>$ext,
            'size'=>$this->driver()->size($fpath),
            'time'=>$this->driver()->lastModified($fpath),
            'image-width'=>0,
            'image-height'=>0,
        ];

        if (in_array($ext,['jpg','jpeg','png','bmp','svg','gif','webp'])) {
            try {
                $img = Image::make($this->driver()->get($path.'/'.$file));
                $json['image-width'] = $img->width();
                $json['image-height'] = $img->height();
            } catch(\Exception $e) {}
        }
        //dd($json);
		return cfind::openerScript($json);
    }

    private function realName($path)
	{
		$x = explode('/',$path);
		return array_pop($x);
	}
}