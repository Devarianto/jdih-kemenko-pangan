<?php
//Bahasa Inggris ke Indonesia

return [
    'en-id-plain'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dari bahasa English ke Bahasa Indonesia',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke Bahasa Indonesia. Terjemahkan dengan grammar bahasa Indonesia, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : Is a mineral mining company affiliate of Freeport-McMoRan (FCX) and MIND ID Indonesia\'s Mining Industry. PTFI mines and process ores produces concentrates containing copper, gold and silver.  We market concentrates all over the world, and mainly to domestic copper smelter, PT Smelting.',
        ],
        [
            'role'=>'assistant',
            'content'=>'PTFI merupakan perusahaan tambang mineral afiliasi dari Freeport-McMoRan (FCX) dan Mining Industry Indonesia ( MIND ID ). PTFI menambang dan memproses bijih menghasilkan konsentrat yang mengandung tembaga, emas dan perak. Kami memasarkan konsentrat ke seluruh penjuru dunia dan terutama ke smelter tembaga dalam negeri, PT Smelting.',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke Bahasa Indonesia. Terjemahkan dengan grammar bahasa Indonesia, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
    'en-id-html'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan penterjemahan kalimat dalam format HTML, menterjemah dari bahasa Germany (Deutsch) ke Bahasa Indonesia',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke Bahasa Indonesia. Terjemahkan dengan grammar bahasa Indonesia, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : <p>Is a mineral mining company affiliate of Freeport-McMoRan (FCX) and MIND ID Indonesia\'s Mining Industry.</p> <p>PTFI mines and process ores produces concentrates containing copper, gold and silver.  We market concentrates all over the world, and mainly to domestic copper smelter, PT Smelting.</p>',
        ],
        [
            'role'=>'assistant',
            'content'=>'<p>PTFI merupakan perusahaan tambang mineral afiliasi dari Freeport-McMoRan (FCX) dan Mining Industry Indonesia ( MIND ID ).</p><p> PTFI menambang dan memproses bijih menghasilkan konsentrat yang mengandung tembaga, emas dan perak. Kami memasarkan konsentrat ke seluruh penjuru dunia dan terutama ke smelter tembaga dalam negeri, PT Smelting.</p>',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke Bahasa Indonesia. Terjemahkan dengan grammar bahasa Indonesia, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon :[query]',
        ],
    ],
];