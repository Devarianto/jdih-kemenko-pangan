<?php

namespace Cactuar\Admin\Http\Controllers\AI\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cactuar\Admin\Traits\Controllers\BaseTrait;
use Cactuar\Admin\Traits\Controllers\ConfTrait;
use Cactuar\Admin\Models\AI\BillingAI;

class SettingController extends Controller
{
    use BaseTrait, ConfTrait;
    
    public function configFields()
    {
        $curl = BillingAI::curl('faq');
        $faq = array_get(json_decode(curl_exec($curl),true)?:[],'response.faq') ?: [];
        curl_close($curl);
        
        $fields = [
            'credit' => [
                'subtitle' => 'AI Credit',
                'type' => 'free',
                'html' => view('cactuar::admin.ai.ai-token', [
                    'token' => num2string(array_get(BillingAI::me(), 'webarqToken') ?: 0, 2),
                    'usage' => num2string(array_get(BillingAI::me(), 'totalUsage') ?: 0, 2),
                ])->render()
            ],
            'subtitle' => [
                'type' => 'free',
                'subtitle' => 'Feature List'
            ],
            'spam-checker' => [
                'type' => 'switch',
                'label' => 'Spam Checker'
            ],
            'moderation' => [
                'type' => 'switch',
                'label' => 'Negative Keywords Checker'
            ],
            'correction' => [
                'type' => 'switch',
                'label' => 'Correction'
            ],
            'translate' => [
                'type' => 'switch',
                'label' => 'Translation'
            ],
            'content' => [
                'type' => 'switch',
                'label' => 'Suggest Content'
            ],
            'meta' => [
                'type' => 'switch',
                'label' => 'Meta Data Suggestion',
            ],
            'btn-submit' => [
                'type' => 'free',
                'html' => '<input type="submit" class="btn btn-primary btn-custom" value="Update Feature">'
            ],
            'faq' => [
                'subtitle' => 'Frequently Asked Question',
                'type' => 'free',
                'html' => view('cactuar::admin.ai.ai-faq',['faq'=>$faq ?? []])->render()
            ]
        ];

        foreach(config('cadmin.ai.enable') as $k => $v){
            if($v != true)
                unset($fields[$k]);
        }
        return $fields;
    }

    public function configAppend(){
        return '
<script>
$("input[type=submit][value=UPDATE]").hide();
$("input.btn-custom[type=submit][value=UPDATE]").show();
</script>';
    }
}
