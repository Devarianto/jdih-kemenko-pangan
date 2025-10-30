<?php
//France (Francais) ke English

return [
    'fr-en-plain'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dari bahasa France (Francais) ke English',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa France (Francais) ke English. Terjemahkan dengan grammar English, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : Quel plaisir de flâner dans les jardins
                des châteaux de la Loire ! A la française ou à l’anglaise, géométriques ou échevelés, toujours magnifiquement fleuris, dotés de potagers gourmands ou de roseraies odorantes, les jardins et parcs paysagers du Val de Loire
                émerveillent autant que les châteaux qu’ils abritent. On y butine un certain art de vivre végétal, comme au temps de la Renaissance.',
        ],
        [
            'role'=>'assistant',
            'content'=>'What a pleasure to stroll in the gardens of the Loire castles! Whether in the French or English style, geometric or wild, always beautifully flowered, equipped with gourmet vegetable gardens or fragrant rose gardens, the gardens and landscaped parks of the Loire Valley are as enchanting as the castles they house. One can savor a certain art of plant-based living there, reminiscent of the time of the Renaissance.',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa France (Francais) ke English. Terjemahkan dengan grammar English, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
    'fr-en-html'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan penterjemahan kalimat dalam format HTML, menterjemah dari bahasa France (Francais) ke English',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa France (Francais) ke English. Terjemahkan dengan grammar English, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : <li>Recevoir le livre de compte Tahapan iB en tant que preuve d\'épargne ainsi que comme enregistrement des transactions sur le compte</li>
                <li>Recevoir la carte de guichet automatique (ATM)/Débit BCA Syariah qui peut être utilisée pour effectuer diverses transactions aux guichets automatiques BCA largement répartis dans toute l\'Indonésie, ainsi que des milliers de guichets automatiques portant les logos Prima et Alto, et faire des achats chez des centaines de milliers de commerçants portant la mention Debit BCA en Indonésie</li>
                <li>Disposer de la fonction de virement automatique</li>
                <li>Disposer du service de prélèvement automatique pour la Zakat</li>',
        ],
        [
            'role'=>'assistant',
            'content'=>'<li>Receive the Tahapan iB account book as proof of savings as well as a record of transactions on the account</li> <li>Receive the Automatic Teller Machine (ATM)/BCA Syariah Debit Card which can be used to perform various transactions at widely distributed BCA ATMs throughout Indonesia, as well as thousands of ATMs bearing the Prima and Alto logos, and make purchases at hundreds of thousands of merchants displaying the Debit BCA label in Indonesia</li> <li>Have access to the automatic transfer function</li> <li>Have access to the automatic deduction service for Zakat</li>',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa France (Francais) ke English. Terjemahkan dengan grammar English, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
];