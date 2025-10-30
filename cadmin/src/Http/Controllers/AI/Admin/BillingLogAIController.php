<?php namespace Cactuar\Admin\Http\Controllers\AI\Admin;

use App\Http\Controllers\Controller;
use Cactuar\Admin\Models\AI\BillingAI;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Illuminate\Pagination\LengthAwarePaginator;
use Cactuar\Admin\Helpers\helper;
use Carbon\Carbon;

class BillingLogAIController extends Controller
{
	use BaseTrait;

	protected $perpage = 30;

	public function getIndex()
	{
		$this->data($data,$total);

		$module = $this->module();
		$paginator = new LengthAwarePaginator([], $total, $this->perpage, LengthAwarePaginator::resolveCurrentPage(), array('path' => LengthAwarePaginator::resolveCurrentPath()));
		return view('cactuar::admin.ai.ai-billing',compact('data','paginator','module'));
	}

	public function getDownload()
	{
		$this->data($data,$total,'download');
		
		$csv = [[
			'action','usage','saldo','admin','ip','note','created',
		]];

		foreach($data as $i) {
			$csv[] = [
				array_get($i,'action'),
				array_get($i,'webarqToken'),
				array_get($i,'saldoAkhir'),
				array_get($i,'adminName'),
				array_get($i,'ip'),
				array_get($i,'note'),
				array_get($i,'createdAt'),
				];
		}
		
		return helper::csv($csv,'log');
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

		$curl = BillingAI::curl('log?'.http_build_query($params));
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
			$curl = BillingAI::curl('log?'.http_build_query($params));
			$res =  json_decode(curl_exec($curl),true) ?: [];
			$total = (double) array_get($res,'response.totalRow');
			$data = array_get($res,'response.data') ?: [];
		}

		return;
	}
}