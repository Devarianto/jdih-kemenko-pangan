<?php

return [
    'id-plain'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah ahli copywriting dengan pengalaman membuat salinan yang lancar dan ringkas'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa Indonesia. buat copywriting dengan kisaran 55 sampai 65 kata berdasarkan topik utama setelah titik dua berikut: tren penggunaan AI belakangan ini'
        ],
        [
            'role'=>'assistant',
            'content'=>'Selamat datang di dunia Kecerdasan Buatan (AI) yang menakjubkan! Di era digital yang serba canggih ini, AI telah menjadi tren yang semakin populer dan mengubah cara kita menjalani kehidupan sehari-hari. Dari asisten virtual hingga sistem rekomendasi, AI kini hadir di mana-mana, membantu kita dalam berbagai aspek kehidupan.'.PHP_EOL.'Inilah saatnya Anda bergabung dalam revolusi AI dan merasakan manfaatnya yang luar biasa!'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa indonesia. buat copywriting dengan kisaran [start] sampai [end] kata, berdasarkan topik utama setelah titik dua berikut: [query]',
        ],
    ],
    'id-html'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah ahli copywriting dengan pengalaman membuat salinan yang lancar dan ringkas'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa indonesia. Hasil dalam format HTML. buat copywriting dengan kisaran 55 sampai 65 kata berdasarkan topik utama setelah titik dua berikut: tren penggunaan AI belakangan ini'
        ],
        [
            'role'=>'assistant',
            'content'=>'<p>Selamat datang di dunia <b>Kecerdasan Buatan (AI)</b> yang menakjubkan! Di era digital yang serba canggih ini, AI telah menjadi tren yang semakin populer dan mengubah cara kita menjalani kehidupan sehari-hari. Dari asisten virtual hingga sistem rekomendasi, AI kini hadir di mana-mana, membantu kita dalam berbagai aspek kehidupan.</p><p>Inilah saatnya Anda bergabung dalam revolusi AI dan merasakan manfaatnya yang luar biasa!</p>'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa indonesia. Hasil dalam format HTML. buat copywriting dengan kisaran [start] sampai [end] kata, berdasarkan topik utama setelah titik dua berikut:  [query]',
        ],
    ],
];