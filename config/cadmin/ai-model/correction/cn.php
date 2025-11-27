<?php

return [
    'cn-plain'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah seorang ahli dalam tata bahasa Chinese (Mandarin)'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa Chineese (Mandarin) yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa Chineese (Mandarin). Perbaiki kalimat baku setelah titik dua berikut: 从产品/供应商搜索到订单管理，付款及履约的无缝衔接。'
        ],
        [
            'role'=>'assistant',
            'content'=>'从产品/供应商搜索，到订单管理、付款及履约，实现了无缝的衔接。'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa Chineese (Mandarin) yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa Chineese (Mandarin). Perbaiki kalimat baku setelah titik dua berikut: [query]',
        ],
    ],
    'cn-html'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah seorang ahli dalam tata bahasa Chinese (Mandarin)'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa Chineese (Mandarin) yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa Chineese (Mandarin). Pertahankan tag html jangan diubah. Perbaiki kalimat baku setelah titik dua berikut: <p><span style="font-size:18px"><span style="color:#ff8c00"><strong>Biaya</strong></span></span></p>

            <div class="table">
            <table border="1" cellpadding="0" cellspacing="0">
                    <thead>
                            <tr>
                                    <th scope="col">KETERANGAN</th>
                                    <th scope="col">JUMLAH (IDR)</th>
                            </tr>
                    </thead>
                    <tbody>
                            <tr>
                                    <td>Setoran Awal</td>
                                    <td style="text-align:right">100.000</td>
                            </tr>
                            <tr>
                                    <td>Setoran Fleksibel</td>
                                    <td style="text-align:right">Minimal 50.000</td>
                            </tr>
                            <tr>
                                    <td>Setoran Terjadwal</td>
                                    <td style="text-align:right">Minimal 50.000 dan berlaku kelipatan</td>
                            </tr>
                            <tr>
                                    <td>Biaya Administrasi Bulanan</td>
                                    <td style="text-align:right">0</td>
                            </tr>
                            <tr>
                                    <td>Biaya Penutupan Rekening</td>
                                    <td style="text-align:right">50.000</td>
                            </tr>
                    </tbody>
            </table>
            </div>
            <ul>
                    <li>Minimal Rp. 50.000 &amp; berlaku kelipatan Rp. 50.000</li>
                    <li>Tanggal pendebetan setoran adalah tanggal 1 s/d 28 setiap bulan</li>
                    <li>Bebas memilih jangka waktu setoran dengan mengisi formulir Transfer Otomatis</li>
                    <li>Pendebetan setoran dilakukan otomatis dari rekening induk di BCA Syariah dan tidak harus milik nasabah yang sama</li>
            </ul>'
        ],
        [
            'role'=>'assistant',
            'content'=>'<p><span style="font-size:18px"><span style="color:#ff8c00"><strong>费用</strong></span></span></p> <div class="table"> <table border="1" cellpadding="0" cellspacing="0"> <thead> <tr> <th scope="col">项目</th> <th scope="col">金额（IDR）</th> </tr> </thead> <tbody> <tr> <td>初始存款</td> <td style="text-align:right">100,000</td> </tr> <tr> <td>灵活存款</td> <td style="text-align:right">最低 50,000</td> </tr> <tr> <td>定期存款</td> <td style="text-align:right">最低 50,000，且为其倍数</td> </tr> <tr> <td>每月行政费</td> <td style="text-align:right">0</td> </tr> <tr> <td>账户关闭费</td> <td style="text-align:right">50,000</td> </tr> </tbody> </table> </div> <ul> <li>最低 Rp. 50,000，且为其倍数 Rp. 50,000</li> <li>扣款日期为每月1日至28日</li> <li>可自由选择存款期限，填写自动转账表格</li> <li>自动从 BCA Syariah 的母账户扣款，不必是同一客户的账户</li> </ul>'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa Chineese (Mandarin) yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa Chineese (Mandarin). Pertahankan tag html jangan diubah. Perbaiki kalimat baku setelah titik dua berikut: [query]',
        ],
    ],
];