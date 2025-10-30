<?php
//France (Francais) ke Chinese (Mandarin)

return [
    'fr-cn-plain'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dari bahasa France (Francais) ke Chinese (Mandarin)',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa France (Francais) ke Chinese (Mandarin). Terjemahkan dengan grammar bahasa Chinese (Mandarin), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : Découvrez des produits et des fournisseurs pour votre entreprise parmi des millions d\'offres dans le monde entier.',
        ],
        [
            'role'=>'assistant',
            'content'=>'在全球数百万的供应商和产品中为您的企业寻找最佳选择。',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa France (Francais) ke Chinese (Mandarin). Terjemahkan dengan grammar bahasa Chinese (Mandarin), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
    'fr-cn-html'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan penterjemahan kalimat dalam format HTML, menterjemah dari bahasa France (Francais) ke Chineese (Mandarin)',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa France (Francais) ke Chineese (Mandarin). Terjemahkan dengan grammar Chineese (Mandarin), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : <p><strong><span style="font-size:18px"><span style="color:#ff851c">Avantages</span></span></strong></p>

            <ul>
                    <li><strong><span style="color:#0066b3"><span style="font-size:16px">C\'est facile</span>, </span></strong>ouvrir un compte sans aller à la banque.</li>
            </ul>',
        ],
        [
            'role'=>'assistant',
            'content'=>'<p><strong><span style="font-size:18px"><span style="color:#ff851c">优势</span></span></strong></p> <ul> <li><strong><span style="color:#0066b3"><span style="font-size:16px">很容易</span>, </span></strong>开设a账户而不必去银行。</li> </ul>',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa France (Francais) ke Chineese (Mandarin). Terjemahkan dengan grammar Chineese (Mandarin), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
];