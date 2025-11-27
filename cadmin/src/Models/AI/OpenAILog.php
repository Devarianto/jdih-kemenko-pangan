<?php namespace Cactuar\Admin\Models\AI;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\Schema;

class OpenAILog extends Model
{
    protected $table = 'openai_api_logs';

    public static function write($method = 'GET', $path = '', $body = [], $status = [], $response = [], $token = 0)
    {
        if (Schema::hasTable('openai_api_logs')) {
            $res = new self;
            $res->user_id = Auth::check() ? Auth::user()->id : null;
            $res->username = Auth::check() ? Auth::user()->name : '-';
            $res->user_display_name = Auth::check() ? Auth::user()->display_name : '-';
            $res->method = $method;
            $res->path = $path;
            $res->body = json_encode($body);
            $res->http_code = array_get($status, 'code');
            $res->status = array_get($status, 'status');
            $res->response = json_encode($response);
            $res->token_usage = $token;
            $res->save();
        }
    }
}