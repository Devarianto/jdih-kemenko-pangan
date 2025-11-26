<?php

return [
	'enable'=>[
		'translate'=>true,
		'meta'=>true,
		'content'=>true,
		'spam-checker'=>false, //masih pengujian, belum disarankan dipakai
		'moderation'=>false,
		'correction'=>true
	],	
	'webarq-ai'=>[
		'url'=>env('WEBARQ_AI_URL',''),
		'key'=>env('WEBARQ_AI_KEY',''),
	],
	'dev' => config('WEBARQ_AI_DEV', false),
];