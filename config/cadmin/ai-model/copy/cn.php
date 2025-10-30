<?php

return [
    'cn-plain'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah ahli copywriting dalam bahasa Chinese (Mandarin) dengan pengalaman membuat salinan yang lancar dan ringkas'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa Chineese (Mandarin). buat copywriting dengan kisaran 55 sampai 65 kata berdasarkan topik utama setelah titik dua berikut: SimPel iB, merupakan tabungan untuk siswa/siswi dalam rangka edukasi dan inklusi keuangan serta mendorong budaya menabung sejak dini dengan persyaratan mudah dan sederhana, serta fitur yang menarik.'
        ],
        [
            'role'=>'assistant',
            'content'=>'SimPel iB是专为学生设计的储蓄账户，旨在教育和金融包容，鼓励从小养成储蓄习惯。简单易懂的条件和吸引人的功能，让储蓄变得轻松有趣。'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam Chinese (Mandarin). buat copywriting dengan kisaran [start] sampai [end] kata, berdasarkan topik utama setelah titik dua berikut: [query]',
        ],
    ],
    'cn-html'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah ahli copywriting dalam bahasa Chinese (Mandarin) dengan pengalaman membuat salinan yang lancar dan ringkas'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa Chineese (Mandarin). Hasil dalam format HTML. buat copywriting dengan kisaran 55 sampai 65 kata berdasarkan topik utama setelah titik dua berikut: <p style="text-align:justify"><span style="color:#36a5b2"><strong>Biaya Bank</strong></span></p>

            <p style="text-align:justify">Adalah biaya transaksi yang dilakukan melalui BCA Syariah <em>Mobile</em>&nbsp;termasuk apabila transaksi tersebut tidak berhasil dijalankan/diproses oleh Bank.</p>
            
            <div class="table">
            <table border="1" cellpadding="1" cellspacing="1">
                    <thead>
                            <tr>
                                    <th scope="col">KETERANGAN</th>
                                    <th scope="col">JUMLAH (IDR)</th>
                            </tr>
                    </thead>
                    <tbody>
                            <tr>
                                    <td><span style="font-size:14px">Transfer&nbsp;<em>Online&nbsp;</em>ke BCA</span></td>
                                    <td style="text-align:right"><span style="font-size:14px">Bebas Biaya</span></td>
                            </tr>
                            <tr>
                                    <td><span style="font-size:14px">Transfer&nbsp;<em>Online&nbsp;</em>ke Bank Lain</span></td>
                                    <td style="text-align:right"><span style="font-size:14px">6.500</span></td>
                            </tr>
                            <tr>
                                    <td><span style="font-size:14px">Transfer SKN ke Bank Lain</span></td>
                                    <td style="text-align:right"><span style="font-size:14px">2.900</span></td>
                            </tr>
                            <tr>
                                    <td><span style="font-size:14px">Transfer RTGS ke Bank Lain</span></td>
                                    <td style="text-align:right"><span style="font-size:14px">30.000</span></td>
                            </tr>
                            <tr>
                                    <td><span style="font-size:14px">Transfer BI Fast</span></td>
                                    <td style="text-align:right"><span style="font-size:14px">2.500</span></td>
                            </tr>
                            <tr>
                                    <td><span style="font-size:14px">Tarik Tunai Cardless</span></td>
                                    <td style="text-align:right"><span style="font-size:14px">Bebas biaya</span></td>
                            </tr>
                    </tbody>
            </table>
            </div>'
        ],
        [
            'role'=>'assistant',
            'content'=>'<p style="text-align:justify"><span style="color:#36a5b2"><strong>银行费用</strong></span></p> <p style="text-align:justify">通过BCA Syariah <em>Mobile</em>进行的交易费用，包括如果交易未能成功处理的情况。</p> <div class="table"> <table border="1" cellpadding="1" cellspacing="1"> <thead> <tr> <th scope="col">说明</th> <th scope="col">金额（IDR）</th> </tr> </thead> <tbody> <tr> <td><span style="font-size:14px">转账至BCA（在线）</span></td> <td style="text-align:right"><span style="font-size:14px">免费</span></td> </tr> <tr> <td><span style="font-size:14px">转账至其他银行（在线）</span></td> <td style="text-align:right"><span style="font-size:14px">6,500</span></td> </tr> <tr> <td><span style="font-size:14px">转账至其他银行（SKN）</span></td> <td style="text-align:right"><span style="font-size:14px">2,900</span></td> </tr> <tr> <td><span style="font-size:14px">转账至其他银行（RTGS）</span></td> <td style="text-align:right"><span style="font-size:14px">30,000</span></td> </tr> <tr> <td><span style="font-size:14px">BI Fast转账</span></td> <td style="text-align:right"><span style="font-size:14px">2,500</span></td> </tr> <tr> <td><span style="font-size:14px">无卡取款</span></td> <td style="text-align:right"><span style="font-size:14px">免费</span></td> </tr> </tbody> </table> </div>'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa Chinese (Mandarin). Hasil dalam format HTML. buat copywriting dengan kisaran [start] sampai [end] kata, berdasarkan topik utama setelah titik dua berikut:  [query]',
        ],
    ],
];