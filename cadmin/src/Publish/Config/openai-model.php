<?php

$models = [
	'translate',
	'meta-title',
	'meta-description',
	'meta-description-additional',
	'meta-keywords',
	'copy',
	'correction',
	'spam-checker'
];
$arrayModels = [];

foreach($models as $model){
	$directory = __DIR__.'/ai-model/'.$model;
	$files = glob($directory . '/*.php');
	$data = [];	
	foreach($files as $file){
		$filename = pathinfo($file, PATHINFO_FILENAME);
		$filecontent = config('cadmin.ai-model.'.$model.'.'.str_replace('.php','',$filename));
		$data += $filecontent;
	}
	$arrayModels[$model] = $data;
}

return $arrayModels;