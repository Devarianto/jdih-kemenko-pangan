<?php namespace Cactuar\Admin\Models\AI;

use Auth;

class BillingAI
{
	protected static $init = false;
	protected static $me = [];
	protected static $prices = [];

	public static function init()
	{
		if (self::$init == true)
			return;

		self::$init = true;

		if (!config('cadmin.ai.webarq-ai.key') || !config('cadmin.ai.webarq-ai.url'))
			return;

		$curl = self::curl('me');
		$res = json_decode(curl_exec($curl) ?: '{}', true);
		curl_close($curl);
		if (array_get($res,'status') == 200)
			self::$me = array_get($res,'response') ?: [];
		
		$curl = self::curl('prices');
		$res = json_decode(curl_exec($curl) ?: '{}', true);
		curl_close($curl);
		if (array_get($res,'status') == 200)
			self::$prices = array_get($res,'response.prices') ?: [];
	}

	public static function curl($path)
	{
		$header = [
			'Content-Type: application/json',
			'apikey: '.config('cadmin.ai.webarq-ai.key'),
			'origin: '.request()->header('host')
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, config('cadmin.ai.webarq-ai.url').'/'.$path);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		return $ch;
	}

	public static function me()
	{
		self::init();
		return self::$me ?: [];
	}

	public static function prices()
	{
		self::init();
		return self::$prices ?: [];
	}

	public static function priceAvail($platform,$model)
	{
		foreach(self::prices() as $price) {
			if (array_get($price,'platform') == $platform && array_get($price,'model') == $model)
				return true;
		}

		return false;
	}

	public static function openAIAvail()
	{
		return array_get(self::me(),'openai.avail');
	}

	public static function saldoAvail()
	{
		return (double) array_get(self::me(),'webarqToken') >= 100;
	}

	public static function log($platform,$model,$token,$action)
	{
		$result = [];

		$body = [
			'platform'=>$platform,
			'model'=>$model,
			'action'=>$action,
			'token'=>$token,
			'adminId'=> Auth::check() ? Auth::user()->id : 0,
			'adminName'=> Auth::check() ? Auth::user()->display_name : '-',
			'ip'=>request()->ip(),
		];
		$curl = self::curl('log');
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
		$response = curl_exec($curl);
		curl_close($curl);

		$response = (array) json_decode($response);

		if(array_get($response, 'status') == 200)
			$result = $response;

		return $result;
	}
}