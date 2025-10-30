<?php namespace Cactuar\Admin\Http\Controllers\AI\Admin;

use App\Http\Controllers\Controller;
use Cactuar\Admin\Models\AI\BillingAI;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Illuminate\Pagination\LengthAwarePaginator;

class CreditRequestController extends Controller
{
	use BaseTrait;

	protected $perpage = 30;

	public function getIndex()
	{
		$me = BillingAI::me();
		$token = num2string(array_get($me, 'webarqToken') ?: 0, 2);
        $usage = num2string(array_get($me, 'totalUsage') ?: 0, 2);
		$module = $this->module();

		$this->data($data,$total);
		$paginator = new LengthAwarePaginator([], $total, $this->perpage, LengthAwarePaginator::resolveCurrentPage(), array('path' => LengthAwarePaginator::resolveCurrentPath()));
		
		return view('cactuar::admin.ai.ai-credit-request.index',compact('module','token','usage','data','paginator'));
	}

	public function data(&$data=[],&$total=0,$type='html')
	{
		$params = [
			'start'=>'',
			'end'=>'',
			'offset'=>0,
			'limit'=>$this->perpage,
		];

		if  (request()->get('range')) {
			$x = explode(' - ',request()->get('range'));
			if (count($x)>=2) {
				$params['start'] = date('Y-m-d',strtotime(array_get($x,0)));
				$params['end'] = date('Y-m-d',strtotime(array_get($x,1)));
			}
		}else{
			//$params['start'] = Carbon::now()->subMonth('1')->format('Y-m-d');
			//$params['end'] = Carbon::now()->format('Y-m-d');
		}
		
		if (request()->get('page')) {
			$params['offset'] = ((int) request()->get('page') - 1) * $this->perpage;
		}

		$curl = BillingAI::curl('credit/request?'.http_build_query($params));
		$res =  json_decode(curl_exec($curl),true) ?: [];
		
		if (array_get($res,'status') != 200) {
			$data = [];
			return;
		}
	
		$total = (double) array_get($res,'response.totalRow');
		$data = array_get($res,'response.data') ?: [];

		if ($type == 'download' && count($data) < $total) { //re-run for get all data
			$params['offset'] = 0;
			$params['limit'] = $total;
			$curl = BillingAI::curl('credit/request?'.http_build_query($params));
			$res =  json_decode(curl_exec($curl),true) ?: [];
			$total = (double) array_get($res,'response.totalRow');
			$data = array_get($res,'response.data') ?: [];
		}

		return;
	}

	public function getRequest()
	{
		$curl = BillingAI::curl('credit/ppn');
		$res = json_decode(curl_exec($curl),true);
		curl_close($curl);

		$ppn = array_get($res,'status') == 200 ? array_get($res,'response.ppn') : 0;
		$minTopup = array_get($res,'status') == 200 ? (array_get($res,'response.minTopup') > 0 ? array_get($res,'response.minTopup') - 1 : 99999) : 99999;
		$module = $this->module();

		return view('cactuar::admin.ai.ai-credit-request.form',compact('module','ppn', 'minTopup'));
	}

	public function postRequest()
	{
		$body = [
			'billingEmail'=>request()->get('email'),
			'credit'=>(double) request()->get('amount'),
			'adminId'=>(int) \Auth::user()->id,
			'adminName'=>\Auth::user()->display_name,
			'ip'=>request()->ip(),
		];
		
		$curl = BillingAI::curl('credit/request');
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
		$res = json_decode(curl_exec($curl),true);
		curl_close($curl);

		if (array_get($res,'status') != 200)
			return redirect()->back()->withError(implode('.', array_get($res,'messages') ?: ['uknown error']));

		\Cactuar\Admin\Models\Log::write($this->module(), 'request', 0, request()->get('email'));
		return redirect()->back()->withSuccess('Request has been sent');
	}
}