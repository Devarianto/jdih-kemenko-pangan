<?php

return [
    'de-plain'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah seorang ahli dalam tata bahasa Germany (Deutsch)'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa Germany (Deutsch) yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa Germany (Deutsch). Perbaiki kalimat baku setelah titik dua berikut: Kontaktieren Sie eine Vielzahl von Lieferanten mit unabhängig geprüften Qualifikationen und Fähigkeiten. Achten Sie auf das "Verified"-Logo, um erfahrene Lieferanten zu finden, auf die sich Ihr Unternehmen verlassen kann.'
        ],
        [
            'role' => 'assistant',
            'content' => 'Kontaktieren Sie eine Vielzahl von Lieferanten mit unabhängig geprüften Qualifikationen und Fähigkeiten. Achten Sie auf das "Verified"-Logo, um erfahrene Lieferanten zu finden, auf die sich Ihr Unternehmen verlassen kann.'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa Germany (Deutsch) yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa Germany (Deutsch). Perbaiki kalimat baku setelah titik dua berikut: [query]',
        ],
    ],
    'de-html'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah seorang ahli dalam tata bahasa Germany (Deutsch)'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar Germany (Deutsch) yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa Germany (Deutsch). Pertahankan tag html jangan diubah. Perbaiki kalimat baku setelah titik dua berikut: <p><span style="font-size:18px"><span style="color:#ff8c00"><strong>Ketentuan Setoran Terjadwal</strong></span></span></p>

            <ul>
                    <li>Minimal Rp. 50.000 &amp; berlaku kelipatan Rp. 50.000</li>
                    <li>Tanggal pendebetan setoran adalah tanggal 1 s/d 28 setiap bulan</li>
                    <li>Bebas memilih jangka waktu setoran dengan mengisi formulir Transfer Otomatis</li>
                    <li>Pendebetan setoran dilakukan otomatis dari rekening induk di BCA Syariah dan tidak harus milik nasabah yang sama</li>
            </ul>'
        ],
        [
            'role'=>'assistant',
            'content'=>'<p><span style="font-size:18px"><span style="color:#ff8c00"><strong>Bedingungen für regelmäßige Einzahlungen</strong></span></span></p> <ul> <li>Mindestens Rp. 50.000 &amp; in Vielfachen von Rp. 50.000 gültig</li> <li>Einzahlungsabbuchung erfolgt am 1. bis 28. eines jeden Monats</li> <li>Freie Wahl der Einzahlungsdauer durch Ausfüllen des Formulars für automatische Überweisungen</li> <li>Die Einzahlungsabbuchung erfolgt automatisch vom Hauptkonto bei BCA Syariah und muss nicht demselben Kunden gehören</li> </ul>'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar Germany (Deutsch) yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa Germany (Deutsch). Pertahankan tag html jangan diubah. Perbaiki kalimat baku setelah titik dua berikut: [query]',
        ],
    ],
];