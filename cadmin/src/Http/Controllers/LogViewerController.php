<?php

namespace Cactuar\Admin\Http\Controllers;

use App\Http\Controllers\Controller;

class LogViewerController extends Controller
{
	private $logFiles = [];

	public function __construct()
	{
		$this->logFiles = \File::allFiles(storage_path('logs'));
	}

	public function getIndex()
    {
        if (!file_exists(storage_path('logs'))) {
            return [];
        }

        $logFiles = $this->logFiles;

        // Sort files by modified time DESC
        usort($logFiles, function ($a, $b) {
            return -1 * strcmp($a->getMTime(), $b->getMTime());
        });

        return view('cactuar::admin.listing-log', compact('logFiles'));
    }

	public function fileExists($path)
	{
		foreach($this->logFiles as $v) {
			if ($path == $v->getFileName())
				return true;
		}

		return false;
	}

    public function getView()
    {
        $fileName = request()->get('file');
        if ($this->fileExists($fileName)) {
            $path = storage_path('logs/'.$fileName);

            // return response()->file($path, ['content-type' => 'text/plain']);
            return view('cactuar::admin.listing-log-detail',['path' => $path]);
        }

        abort(404);
    }

    public function getDownload()
    {
        $fileName = request()->get('file');
        if ($this->fileExists($fileName)) {
            $path = storage_path('logs/'.$fileName);
            $downloadFileName = env('APP_ENV').'.'.$fileName;

            return response()->download($path, $downloadFileName);
        }

        return 'Invalid file name.';
    }

    public function getDelete()
    {
        $fileName = request()->get('file');

        $logName = [];
        foreach ($this->logFiles as $v) {
            $logName[] = $v->getfileName();
        }

        if ($this->fileExists($fileName)) {
            if (in_array($fileName,$logName)) {
                unlink(storage_path('logs/'.$fileName));
            }
		}
        return back();
    }


}