<?php namespace Cactuar\Admin\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use Validator;
use Cactuar\Admin\Models\AI\OpenAI;

class OpenAIController extends Controller
{
	public function postTranslate()
	{
		if (config('cadmin.ai.dev') == true)
			return response()->json(json_decode('{"status":200,"data":{"text":"Life","webarqToken":6.13}}'));

		if (config('cadmin.ai.enable.translate') != true || conf('openai-setting')->translate != 'on')
			return response()->json(['status'=>400,'errors'=>['feature is disabled']]);

		$post = request()->all();
		$rules = [
			'q'=>'string|required',
			'lang.from'=>'string|required|in:'.implode(',',config('cadmin.lang.codes')),
			'lang.to'=>'string|required|in:'.implode(',',config('cadmin.lang.codes')),
			'type'=>'string|required|in:html,plain',
		];
		$valid = Validator::make($post,$rules);
		if ($valid->fails())
			return response()->json(['status'=>400,'errors'=>['invalid request']]);
			
		$messages = config('cadmin.openai-model.translate.'.$post['lang']['from'].'-'.$post['lang']['to'].'-'.$post['type']);
		foreach($messages as $k=>$v)
			$messages[$k]['content'] = str_replace('[query]',$post['q'],$v['content']);
		
		$body = [
			'model'=>'gpt-3.5-turbo',
			'messages'=>$messages,
			'temperature'=>0.1,
			//'max_tokens'=>1000,
		];

		$ai = OpenAI::init('chat/completions','translate','gpt-3',$body)->call();
		if ($ai->success() != true)
			return response()->json(['status'=>500,'errors'=>$ai->messages()]);
		
		return response()->json(['status'=>200,'data'=>['text'=>$ai->data('choices.0.message.content'), 'aiToken' => $ai->data('usage.total_tokens'), 'webarqToken' => num2string($ai->data('webarqToken'), 2)]]);
	}

	public function postMetaTitle()
	{
		if (config('cadmin.ai.dev') == true)
			return response()->json(json_decode('{"status":200,"data":{"text":"Life","webarqToken":6.13}}'));

		if (config('cadmin.ai.enable.meta') != true || conf('openai-setting')->meta != 'on')
			return response()->json(['status'=>400,'errors'=>['feature is disabled']]);
		
		$post = request()->all();
		$rules = [
			'q'=>'string|required',
			'baselang'=>'string|in:'.implode(',',config('cadmin.lang.codes')),
		];
		
		$valid = Validator::make($post,$rules);
		if ($valid->fails())
			return response()->json(['status'=>400,'errors'=>['invalid request']]);

		if (!array_get($post,'baselang'))
			$post['baselang'] = config('cadmin.lang.default');

		$messages = config('cadmin.openai-model.meta-title.'.$post['baselang']);
		foreach($messages as $k=>$v)
			$messages[$k]['content'] = str_replace('[query]',strip_tags($post['q']),$v['content']);

		$body = [
			'model'=>'gpt-3.5-turbo',
			'messages'=>$messages,
			'temperature'=>0.2,
			//'max_tokens'=>160,
		];

		$ai = OpenAI::init('chat/completions','meta title','gpt-3',$body)->call();
		if ($ai->success() != true)
			return response()->json(['status'=>500,'errors'=>$ai->messages()]);
	
		return response()->json(['status'=>200,'data'=>['text'=>trim($ai->data('choices.0.message.content')), 'aiToken' => $ai->data('usage.total_tokens'),'webarqToken' => num2string($ai->data('webarqToken'), 2)]]);
	}

	public function postMetaDescription()
	{
		if (config('cadmin.ai.dev') == true)
			return response()->json(json_decode('{"status":200,"data":{"text":"Life","webarqToken":6.13}}'));

		if (config('cadmin.ai.enable.meta') != true || conf('openai-setting')->meta != 'on')
			return response()->json(['status'=>400,'errors'=>['feature is disabled']]);
		
		$post = request()->all();
		$rules = [
			'q'=>'string|required',
			'baselang'=>'string|in:'.implode(',',config('cadmin.lang.codes')),
		];
		
		$valid = Validator::make($post,$rules);
		if ($valid->fails())
			return response()->json(['status'=>400,'errors'=>['invalid request']]);

		if (!array_get($post,'baselang'))
			$post['baselang'] = config('cadmin.lang.default');

		$messages = config('cadmin.openai-model.meta-description.'.$post['baselang']);
		foreach($messages as $k=>$v)
			$messages[$k]['content'] = str_replace('[query]',strip_tags($post['q']),$v['content']);

		$body = [
			'model'=>'gpt-3.5-turbo',
			'messages'=>$messages,
			'temperature'=>0.2,
			//'max_tokens'=>1000,
		];

		$ai = OpenAI::init('chat/completions','meta description','gpt-3',$body)->call();
		if ($ai->success() != true)
			return response()->json(['status'=>500,'errors'=>$ai->messages()]);
		
		$aitoken = $ai->data('usage.total_tokens');
		$wtoken = $ai->data('webarqToken');
		
		$meta = trim($ai->data('choices.0.message.content'));		
		$try = 0;
		while (strlen($meta) > 160 && $try < 3) {
			$messages = config('cadmin.openai-model.meta-description-additional.'.$post['baselang']);
			foreach($messages as $k=>$v) {
				$messages[$k]['content'] = str_replace('[query]',strip_tags($post['q']),$v['content']);
				$messages[$k]['content'] = str_replace('[meta]',$meta,$v['content']);
			}
			$body = [
				'model'=>'gpt-3.5-turbo',
				'messages'=>$messages,
				'temperature'=>0.5,
				//'max_tokens'=>1000,
			];

			$ai = OpenAI::init('chat/completions','meta description','gpt-3',$body)->call();
			if ($ai->success() != true)
				return response()->json(['status'=>500,'errors'=>$ai->messages()]);
			$meta = trim($ai->data('choices.0.message.content'));
			
			$aitoken += $ai->data('usage.total_tokens');
			$wtoken += $ai->data('webarqToken');
			$try++;
		}
		
		return response()->json(['status'=>200,'data'=>['text'=>$meta, 'aiToken' => num2string($aitoken),'webarqToken' => num2string($wtoken, 2)]]);
	}

	public function postMetaKeyword()
	{
		if (config('cadmin.ai.dev') == true)
			return response()->json(json_decode('{"status":200,"data":{"text":"Life","webarqToken":6.13}}'));

		if (config('cadmin.ai.enable.meta') != true || conf('openai-setting')->meta != 'on')
			return response()->json(['status'=>400,'errors'=>['feature is disabled']]);
		
		$post = request()->all();
		$rules = [
			'q'=>'string|required',
			'baselang'=>'string|in:'.implode(',',config('cadmin.lang.codes')),
		];
		
		$valid = Validator::make($post,$rules);
		if ($valid->fails())
			return response()->json(['status'=>400,'errors'=>['invalid request']]);

		if (!array_get($post,'baselang'))
			$post['baselang'] = config('cadmin.lang.default');

		$messages = config('cadmin.openai-model.meta-keywords.'.$post['baselang']);
		foreach($messages as $k=>$v)
			$messages[$k]['content'] = str_replace('[query]',strip_tags($post['q']),$v['content']);

		$body = [
			'model'=>'gpt-3.5-turbo',
			'messages'=>$messages,
			'temperature'=>0.2,
			//'max_tokens'=>1000,
		];

		$ai = OpenAI::init('chat/completions','meta keyword','gpt-3',$body)->call();
		if ($ai->success() != true)
			return response()->json(['status'=>500,'errors'=>$ai->messages()]);
	
		return response()->json(['status'=>200,'data'=>['text'=>trim($ai->data('choices.0.message.content')), 'aiToken' => $ai->data('usage.total_tokens'),'webarqToken' => num2string($ai->data('webarqToken'), 2)]]);
	}

	public function postContent()
	{
		if (config('cadmin.ai.dev') == true)
			return response()->json(json_decode('{"status":200,"data":{"text":"Life","webarqToken":6.13}}'));
		
		if (config('cadmin.ai.enable.content') != true || conf('openai-setting')->content != 'on')
			return response()->json(['status'=>400,'errors'=>['feature is disabled']]);
		
		$post = request()->all();
		$rules = [
			'q'=>'string|required',
			'lang'=>'string|required|in:'.implode(',',config('cadmin.lang.codes')),
			'word'=>'numeric',
			'type'=>'string|required|in:plain,html',
		];
		
		$valid = Validator::make($post,$rules);
		if ($valid->fails())
			return response()->json(['status'=>400,'errors'=>['invalid request']]);
		if (!$post['word'])
			$post['word'] = 60;

		$messages = config('cadmin.openai-model.copy.'.$post['lang'].'-'.$post['type']);
		foreach($messages as $k=>$v){
			$messages[$k]['content'] = str_replace('[query]',($post['type'] == 'plain' ? strip_tags($post['q']) : $post['q']),$v['content']);
			$messages[$k]['content'] = str_replace('[word]',strip_tags($post['word']),$messages[$k]['content']);
			$messages[$k]['content'] = str_replace('[start]',(int) $post['word'] - 10,$messages[$k]['content']);
			$messages[$k]['content'] = str_replace('[end]',(int) $post['word'] + 10,$messages[$k]['content']);
		}

		$body = [
			'model'=>'gpt-3.5-turbo',
			'messages'=>$messages,
			'temperature'=>0.2,
			//'max_tokens'=>1000,
		];

		$ai = OpenAI::init('chat/completions','copywrite','gpt-3',$body)->call();
		if ($ai->success() != true)
			return response()->json(['status'=>500,'errors'=>$ai->messages()]);
	
		return response()->json(['status'=>200,'data'=>['text'=>trim($ai->data('choices.0.message.content')), 'aiToken' => $ai->data('usage.total_tokens'),'webarqToken' => num2string($ai->data('webarqToken'), 2)]]);
	}

	public function postCorrection()
	{
		if (config('cadmin.ai.dev') == true)
			return response()->json(json_decode('{"status":200,"data":{"text":"Life","webarqToken":6.13}}'));
		
		if (config('cadmin.ai.enable.correction') != true || conf('openai-setting')->correction != 'on')
			return response()->json(['status'=>400,'errors'=>['feature is disabled']]);
		
		$post = request()->all();
		$rules = [
			'q'=>'string|required',
			'lang'=>'string|required|in:'.implode(',',config('cadmin.lang.codes')),
			'type'=>'string|required|in:plain,html',
		];
		
		$valid = Validator::make($post,$rules);
		if ($valid->fails())
			return response()->json(['status'=>400,'errors'=>['invalid request']]);

		$messages = config('cadmin.openai-model.correction.'.$post['lang'].'-'.$post['type']);
		foreach($messages as $k=>$v)
			$messages[$k]['content'] = str_replace('[query]', ($post['type'] == 'plain' ? strip_tags($post['q']) : $post['q']),$v['content']);

		$body = [
			'model'=>'gpt-3.5-turbo',
			'messages'=>$messages,
			'temperature'=>0.2,
			//'max_tokens'=>1000,
		];

		$ai = OpenAI::init('chat/completions','correction','gpt-3',$body)->call();
		if ($ai->success() != true)
			return response()->json(['status'=>500,'errors'=>$ai->messages()]);
	
		return response()->json(['status'=>200,'data'=>['text'=>trim($ai->data('choices.0.message.content')), 'aiToken' => $ai->data('usage.total_tokens'),'webarqToken' => num2string($ai->data('webarqToken'), 2)]]);
	}
}