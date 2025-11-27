<?php
//Bahasa Inggris ke France (Francais)

return [
    'en-fr-plain'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dari Bahasa English ke Bahasa France (Francais)',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke Bahasa France (Francais). Terjemahkan dengan grammar bahasa Prancis (Francais), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : Interview with Marie-Amélie Le Fur, President of the French Paralympic and Sports Committee',
        ],
        [
            'role'=>'assistant',
            'content'=>'Festivals, expositions, concerts, événements sportifs ou culturels... En France, il se passe toujours quelque chose. Découvrez notre sélection d\'événements incontournables à vivre lors de votre séjour.',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke Bahasa France (Francais). Terjemahkan dengan grammar bahasa Prancis (Francais), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
    'en-fr-html'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dalam format HTML dari bahasa English ke bahasa France (Francais)',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke France (Francais). Terjemahkan dengan grammar France (Francais), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : <figure class="image">
                <img src="/cfind/source/images/pelaksanaan-survei-kepada-masyarakat-sekitar-untuk-hasil-program-kebun-gizi-1-1024x683.jpg">
            </figure>
            <h5 style="text-align:center;">
                <i>Implementation of Surveys to the Surrounding Community for the Results of the Nutritional Garden Program</i>
            </h5>
            <p>
                <br>
                <span style="background-color:rgb(255,255,255);color:rgb(51,51,51);">The business assistance provided by the MahaDasha Group is well-received by the beneficiaries, especially Sukardi, the Head of Petir Village.
            </span></p>',
        ],
        [
            'role'=>'assistant',
            'content'=>'<figure class="image"> <img src="/cfind/source/images/pelaksanaan-survei-kepada-masyarakat-sekitar-untuk-hasil-program-kebun-gizi-1-1024x683.jpg"> </figure> <h5 style="text-align:center;"> <i>Mise en œuvre des enquêtes auprès de la communauté environnante pour les résultats du programme de jardin nutritionnel</i> </h5> <p> <br> <span style="background-color:rgb(255,255,255);color:rgb(51,51,51);">L\'assistance commerciale fournie par le groupe MahaDasha est bien accueillie par les bénéficiaires, en particulier Sukardi, le chef du village de Petir. </span></p>',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke France (Francais). Terjemahkan dengan grammar France (Francais), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
];