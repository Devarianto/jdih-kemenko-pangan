<?php
//Bahasa Inggris ke Chinese

return [
    'en-cn-plain'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dari Bahasa English ke Bahasa Chinese (Mandarin)',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke Bahasa Chinese (Mandarin). Terjemahkan dengan grammar bahasa Chinesa (Mandarin), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : Travel through Angers to see the terrifying Tenture de l\'Apocalypse, then continue on to Nantes to see giant mechanical installations and mechanical elephants. As night falls, watch Buren\'s metal hoop installation (Les anneaux) emit light.',
        ],
        [
            'role'=>'assistant',
            'content'=>'旅行经过昂热，看看令人惊恐的《启示录挂毯》，然后继续前往南特，看到巨大的机械装置和机械大象。夜幕降临时，观赏布伦的金属环装置《光环》发出光芒。',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke Bahasa Chinese (Mandarin). Terjemahkan dengan grammar bahasa Chinesa (Mandarin), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
    'en-cn-html'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dalam format HTML dari Bahasa English ke Bahasa Chinese (Mandarin)',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke Chinese (Mandarin). Terjemahkan dengan grammar Chinese (Mandarin), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : <p><span style="font-size:18px"><span style="color:#ff8c00"><strong>Costs</strong></span></span></p>
                <div class="table">
                <table border="1" cellpadding="0" cellspacing="0">
                        <thead>
                                <tr>
                                        <th scope="col">DESCRIPTION</th>
                                        <th scope="col">AMOUNT (IDR)</th>
                                </tr>
                        </thead>
                        <tbody>
                                <tr>
                                        <td>Initial Deposit</td>
                                        <td style="text-align:right">100,000</td>
                                </tr>
                                <tr>
                                        <td>Flexible Deposit</td>
                                        <td style="text-align:right">Minimum 50,000</td>
                                </tr>
                                <tr>
                                        <td>Scheduled Deposit</td>
                                        <td style="text-align:right">Minimum 50,000 and multiples thereof</td>
                                </tr>
                                <tr>
                                        <td>Monthly Administrative Fee</td>
                                        <td style="text-align:right">0</td>
                                </tr>
                                <tr>
                                        <td>Account Closure Fee</td>
                                        <td style="text-align:right">50,000</td>
                                </tr>
                        </tbody>
                </table>
                </div>
            ',
        ],
        [
            'role'=>'assistant',
            'content'=>'<p><span style="font-size:18px"><span style="color:#ff8c00"><strong>费用</strong></span></span></p> <div class="table"> <table border="1" cellpadding="0" cellspacing="0"> <thead> <tr> <th scope="col">说明</th> <th scope="col">金额（IDR）</th> </tr> </thead> <tbody> <tr> <td>初始存款</td> <td style="text-align:right">100,000</td> </tr> <tr> <td>灵活存款</td> <td style="text-align:right">最低 50,000</td> </tr> <tr> <td>定期存款</td> <td style="text-align:right">最低 50,000，适用倍数</td> </tr> <tr> <td>每月行政费</td> <td style="text-align:right">0</td> </tr> <tr> <td>账户关闭费</td> <td style="text-align:right">50,000</td> </tr> </tbody> </table> </div>',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke Chinese (Mandarin). Terjemahkan dengan grammar Chinese (Mandarin), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
];