<?php

return [
    'id'=>[
        [
            'role'=>'system',
            'content'=>'Anda ahli SEO & copywriting'
        ],
        [
            'role'=>'user',
            'content'=>'Buat meta description sepanjang 160 character yang bagus untuk SEO dan dapat dibaca manusia dalam bahasa Indonesia. Potong kalimat jika lebih dari 160 character. Buat meta description dari teks setelah tanda titik dua berikut: [query]',
        ],
        [
            'role'=>'assistant',
            'content'=>'[meta]',
        ],
        [
            'role'=>'user',
            'content'=>'perpendek hingga maksimal 160 karakter',
        ]
    ],	
];