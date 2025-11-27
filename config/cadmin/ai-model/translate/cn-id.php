<?php
//Chinese (Mandarin) ke Bahasa Indonesia

return [
    'cn-id-plain'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dari bahasa Chinese (Mandarin) ke Bahasa Indonesia',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Chinese (Mandarin) ke Bahasa Indonesia. Terjemahkan dengan grammar bahasa indonesia, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : 查看订单状态，管理供应商，跟踪付款和发货进展，并通过我的阿里巴巴联系售后支持。',
        ],
        [
            'role'=>'assistant',
            'content'=>'Lihat status pesanan, kelola pemasok, ikuti perkembangan pembayaran dan pengiriman, dan hubungi dukungan purna jual melalui layanan pelanggan Alibaba saya.',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Chinese (Mandarin) ke Bahasa Indonesia. Terjemahkan dengan grammar bahasa indonesia, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
    'cn-id-html'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan penterjemahan kalimat dalam format HTML, menterjemah dari bahasa Chineese (Mandarin) ke Indonesia',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Chineese (Mandarin) ke Indonesia. Terjemahkan dengan grammar Indonesia, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : <p><span style="font-size:18px"><span style="color:#ff8c00"><strong>要求</strong></span></span></p>

            <ul>
                    <li>储户可以是个人或基金会</li>
                    <li>申请人填写并签署BCA Syariah Tahapan iB账户开户申请表</li>
                    <li>申请人携带并提交电子身份证（E-KTP）和税务识别号（NPWP）的复印件</li>
            </ul>',
        ],
        [
            'role'=>'assistant',
            'content'=>'<p><span style="font-size:18px"><span style="color:#ff8c00"><strong>Persyaratan</strong></span></span></p> <ul> <li>Nasabah bisa berupa individu atau yayasan</li> <li>Pelamar mengisi dan menandatangani formulir pembukaan rekening BCA Syariah Tahapan iB</li> <li>Pelamar membawa dan mengajukan salinan Kartu Tanda Penduduk elektronik (E-KTP) dan Nomor Pokok Wajib Pajak (NPWP)</li> </ul>',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Chineese (Mandarin) ke Indonesia. Terjemahkan dengan grammar Indonesia, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
];