<?php namespace Cactuar\Admin\Models\AI;

class OpenAI
{
	protected $path = '';
	protected $model = '';
	protected $action = '';
	protected $body = [];
	protected $messages = [];
	protected $raw = '';
	protected $json = [];
	protected $success = false;
	protected $tokenused = 0;

	public static function init($path,$action,$model,$body=[])
	{
		return new self($path,$action,$model,$body);
	}

	public function __construct($path,$action,$model,$body=[])
	{
		$this->path = $path;
		$this->model = $model;
		$this->body = $body;
		$this->action = $action;

		return $this;
	}

	public function call()
	{
		try{
			if (BillingAI::openAIAvail() != true) {
				$this->messages = ['open ai not available'];
				OpenAILog::write('POST', $this->path, $this->body, ['code' => 500, 'status' => 'failed'], $this->messages, 0);
				return $this;
			}

			if (BillingAI::priceAvail('openai', $this->model) != true) {
				$this->messages = ['model not available'];
				OpenAILog::write('POST', $this->path, $this->body, ['code' => 500, 'status' => 'failed'], $this->messages, 0);
				return $this;
			}	

			if (BillingAI::saldoAvail() != true) {
				$this->messages = ['saldo not available'];
				OpenAILog::write('POST', $this->path, $this->body, ['code' => 500, 'status' => 'failed'], $this->messages, 0);
				return $this;
			}

			$header = [
				'Content-Type: application/json',
				'Authorization: Bearer '.array_get(BillingAI::me(),'openai.key'),
			];

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/'.$this->path);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->body));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$this->raw = curl_exec($ch);
			$curlerr = curl_error($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);

			if ($curlerr) {
				$this->messages = [$curlerr];
				OpenAILog::write('POST', $this->path, $this->body, ['code' => $httpcode, 'status' => $curlerr], [], 0);
				return $this;
			}
			
			$this->json = json_decode($this->raw,true);
			if (!is_array($this->json))
				$this->json = [];
			
			if (!array_get($this->json,'id')) {
				$this->messages = [array_get($this->json,'error.message') ?: 'unknown error'];
				OpenAILog::write('POST', $this->path, $this->body, ['code' => $httpcode, 'status' => 'failed'], $this->json, 0);
				return $this;
			}

			$token = array_get($this->json,'usage.total_tokens');

			if($this->model == 'moderation') 
				$token = 1;

			$billing = BillingAI::log('openai',$this->model,$token,$this->action);

			if(!array_get($this->json, 'webarqToken'))
				$this->json['webarqToken'] = array_get($billing, 'webarqToken') ?: 0;

			OpenAILog::write('POST', $this->path, $this->body, ['code' => $httpcode, 'status' => 'success'], $this->json, $token);

			$this->success = true;
			return $this;
		}catch(\Exception $e){
			Log::info($e);
			$this->success = false;
			$this->messages = [$e->getMessage()];
			
			OpenAILog::write('POST', $this->path, $this->body, ['code' => 500, 'status' => 'failed'], $this->messages, 0);

			return $this;
		}
	}

	public function success()
	{
		return $this->success;
	}

	public function messages()
	{
		return $this->messages;
	}

	public function raw()
	{
		return $this->raw;
	}

	public function json()
	{
		return $this->json;
	}

	public function data($key)
	{
		return array_get($this->json,$key);
	}

	public static function moderation($q,&$flagged=false,&$data=[],&$error=[])
	{
		if(conf('openai-setting')->moderation != 'on' || config('cadmin.ai.enabled.moderation')){
			$error = ['Moderation feature is not enabled'];
			return false;
		}

		$body = [
			"input" => $q,
		];

		$res = self::init('moderations','moderations', 'moderation', $body)->call();
		if ($res->success() != true) {
			$error = $res->messages();
			return false;
		}	

		$data = $res->data('results.0');
		$flagged = $res->data('results.0.flagged');

		return true;
	}

	public static function spamChecked($q,&$spam=false,&$error=[])
	{
		if(conf('openai-setting')->spamChecker != 'on' || config('cadmin.ai.enable.spam-checker') != true){
			$error = ['Spam checker feature is not enabled'];
			return false;
		}

		$messages = config('cadmin.openai-model.spam-checker.'.\lang::active());
		foreach($messages as $k=>$v)
			$messages[$k]['content'] = str_replace('[query]',strip_tags($q),$v['content']);

		$body = [
			'model'=>'gpt-3.5-turbo',
			'messages'=> $messages,
			'temperature'=>0.1,
		];

		$res = self::init('chat/completions', 'spam-checker', 'gpt-3',$body)->call();
		if ($res->success() != true) {
			$error = $res->messages();
			return false;
		}

		$response = str_replace(' ','',str_replace('.', '',strtolower(trim(array_get($res->json(),'choices.0.message.content')))));
		$spam = false;
		if(str_contains($response, 'yes')){
			$spam = true;
		}

		return true;
	}
}