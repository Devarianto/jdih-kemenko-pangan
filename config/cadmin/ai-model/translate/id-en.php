<?php
//Indonesia > English (Deutsch)

return [
    'id-en-plain'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dari bahasa indonesia ke bahasa inggris',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari Bahasa Indonesia ke Bahasa Inggris. JANGAN menerjemahkan singkatan atau akronim. Terjemahkan setelah titik dua berikut :rumah idaman milik kita bersama',
        ],
        [
            'role'=>'assistant',
            'content'=>'our dream house together',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari Bahasa Indonesia ke Bahasa Inggris. JANGAN menerjemahkan singkatan atau akronim. Terjemahkan setelah titik dua berikut:[query]',
        ],
    ],
    'id-en-html'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan penterjemahan kalimat dalam format HTML, menterjemah dari bahasa indonesia ke bahasa inggris',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa indonesia ke bahasa inggris. Hasil dalam format HTML. JANGAN menerjemahkan singkatan atau akronim. Terjemahkan setelah titik dua berikut:<b>idaman</b> milik kita bersama</p>',
        ],
        [
            'role'=>'assistant',
            'content'=>'<p>our <b>dream</b> house together</p>',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa indonesia ke bahasa inggris. Hasil dalam format HTML. JANGAN menerjemahkan singkatan atau akronim. Terjemahkan setelah titik dua berikut:[query]',
        ],
    ],
];