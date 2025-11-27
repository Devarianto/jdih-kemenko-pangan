<?php
//Chinese (Mandarin) ke English

return [
    'cn-en-plain'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dari bahasa Chinese (Mandarin) ke English',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Chinese (Mandarin) ke English. Terjemahkan dengan grammar English, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : 查看订单状态，管理供应商，跟踪付款和发货进展，并通过我的阿里巴巴联系售后支持。',
        ],
        [
            'role'=>'assistant',
            'content'=>'View order status, manage suppliers, track payment and shipping progress, and contact after-sales support through My Alibaba.',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Chinese (Mandarin) ke English. Terjemahkan dengan grammar English, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
    'cn-en-html'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan penterjemahan kalimat dalam format HTML, menterjemah dari bahasa Chineese (Mandarin) ke English',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Chineese (Mandarin) ke English. Terjemahkan dengan grammar English, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : <li>提供自动转账服务</li>
            <li>提供自动扣款清真税服务</li>
            <li>提供在BCA Syariah的ATM上进行的交易服务，包括：
                    <ul>
                            <li>取款、BCA Syariah账户之间转账、转账至BCA、向其他银行转账</li>
                    </ul>
            </li>',
        ],
        [
            'role'=>'assistant',
            'content'=>'<li>Provide automatic transfer services</li> <li>Provide automatic deduction of halal taxes services</li> <li>Provide transaction services at BCA Syariah\'s ATM, including: <ul> <li>Withdrawals, transfers between BCA Syariah accounts, transfers to BCA, transfers to other banks</li> </ul> </li>',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Chineese (Mandarin) ke English. Terjemahkan dengan grammar English, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
];