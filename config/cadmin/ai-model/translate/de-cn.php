<?php
//Germany (Deutsch) ke Chinese

return [
    'de-cn-plain'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dari bahasa Germany (Deutsch) ke Chinese (Mandarin)',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Germany (Deutsch) ke Chinese (Mandarin). Terjemahkan dengan grammar bahasa Chinese (Mandarin), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : Nutzen Sie unsere nahtlose Bestellabwicklung, von der Suche nach Produkten und Lieferanten über Auftragsverwaltung bis hin zur Zahlung.',
        ],
        [
            'role'=>'assistant',
            'content'=>'请利用我们无缝的订单处理流程，从产品和供应商搜索到订单管理，直至付款。',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Germany (Deutsch) ke Chinese (Mandarin). Terjemahkan dengan grammar bahasa Chinese (Mandarin), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
    'de-cn-html'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan penterjemahan kalimat dalam format HTML, menterjemah dari bahasa Germany (Deutsch) ke Chinese (Mandarin)',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Germany (Deutsch) ke Chineese (Mandarin). Terjemahkan dengan grammar Chineese (Mandarin), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : <p><span style="font-size:18px"><span style="color:#ff8c00"><strong>Vorteile</strong></span></span></p>

            <ul>
                <li>Keine Verwaltungsgebühren</li>
                <li>Geringe Ersteinzahlung</li>
                <li>Für alle Altersgruppen geeignet</li>
            </ul>',
        ],
        [
            'role'=>'assistant',
            'content'=>'<p><span style="font-size:18px"><span style="color:#ff8c00"><strong>优势</strong></span></span></p> <ul> <li>无管理费</li> <li>首付金额低</li> <li>适合所有年龄段</li> </ul>',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Germany (Deutsch) ke Chineese (Mandarin). Terjemahkan dengan grammar Chineese (Mandarin), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
];