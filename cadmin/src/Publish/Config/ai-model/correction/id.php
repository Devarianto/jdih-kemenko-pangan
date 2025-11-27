<?php

return [
    'id-plain'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah ahli tata bahasa Indonesia'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa Indonesia yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa indonesia. Perbaiki kalimat baku setelah titik dua berikut: SimPel iB, merupakan tabungan untuk siswa/siswi dalam rangka edukasi dan inklusi keuangan serta mendorong budaya menabung sejak dini dengan persyaratan mudah dan sederhana, serta fitur yang menarik.'
        ],
        [
            'role'=>'assistant',
            'content'=>'SimPel iB merupakan tabungan untuk siswa/siswi dalam rangka edukasi dan inklusi keuangan, serta mendorong budaya menabung sejak dini dengan persyaratan mudah dan sederhana, serta fitur yang menarik.',
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa Indonesia yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa indonesia. Perbaiki kalimat baku setelah titik dua berikut: [query]',
        ],
    ],
    'id-html'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah ahli tata bahasa Indonesia'
        ],
        [
            'role' => 'user',
            'content' => 'Tolong koreksi kalimat berikut dengan grammar bahasa Indonesia yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa Indonesia. Pertahankan tag html jangan diubah. Perbaiki kalimat baku setelah titik dua berikut: <p><span style="font-size:18px"><span style="color:#ff8c00"><strong>Ketentuan Setoran Terjadwal</strong></span></span></p>

            <ul>
                    <li>Minimal Rp. 50.000 &amp; berlaku kelipatan Rp. 50.000</li>
                    <li>Tanggal pendebetan setoran adalah tanggal 1 s/d 28 setiap bulan</li>
                    <li>Bebas memilih jangka waktu setoran dengan mengisi formulir Transfer Otomatis</li>
                    <li>Pendebetan setoran dilakukan otomatis dari rekening induk di BCA Syariah dan tidak harus milik nasabah yang sama</li>
            </ul>'
        ],
        [
            'role'=>'assistant',
            'content'=>'<p><span style="font-size:18px"><span style="color:#ff8c00"><strong>Ketentuan Setoran Terjadwal</strong></span></span></p> <ul> <li>Minimal Rp. 50.000 dan berlaku kelipatan Rp. 50.000.</li> <li>Tanggal pendebetan setoran adalah tanggal 1 hingga 28 setiap bulan.</li> <li>Bebas memilih jangka waktu setoran dengan mengisi formulir Transfer Otomatis.</li> <li>Pendebetan setoran dilakukan otomatis dari rekening induk di BCA Syariah dan tidak harus milik nasabah yang sama.</li> </ul>'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa Indonesia yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa Indonesia. Pertahankan tag html jangan diubah. Perbaiki kalimat baku setelah titik dua berikut: [query]',
        ],
    ],
];