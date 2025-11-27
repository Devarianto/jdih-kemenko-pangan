<?php
//Bahasa Inggris ke Germany (Deutsch)

return [
    'en-de-plain'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dari bahasa english ke Bahasa Germany (Deutsch)',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke Bahasa Germany (Deutsch). Terjemahkan dengan grammar Bahasa Germany (Deutsch), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : The Lufthansa chat assistant will be happy to assist you with any questions you have about your journey from Frankfurt Airport. Receive individual information about check-in and your flight status as well as your stay at Germany’s largest airport.',
        ],
        [
            'role'=>'assistant',
            'content'=>'Der Lufthansa Chat Asisstant unterstützt Sie gerne bei Fragen rund um Ihre Reise ab dem Flughafen Frankfurt. Erhalten Sie individuelle Informationen zu den Themen Check-in und Flugstatus sowie Ihrem Aufenthalt an Deutschlands größtem Flughafen.',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke Bahasa Germany (Deutsch). Terjemahkan dengan grammar Bahasa Germany (Deutsch), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
    'en-de-html'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dalam format HTML dari bahasa english ke Bahasa Germany (Deutsch)',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke Germany (Deutsch). Terjemahkan dengan grammar Germany (Deutsch), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : <figure class="image">
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
            'content'=>'<figure class="image"> <img src="/cfind/source/images/pelaksanaan-survei-kepada-masyarakat-sekitar-untuk-hasil-program-kebun-gizi-1-1024x683.jpg"> </figure> <h5 style="text-align:center;"> <i>Durchführung von Umfragen in der umliegenden Gemeinde für die Ergebnisse des Ernährungsgartenprogramms</i> </h5> <p> <br> <span style="background-color:rgb(255,255,255);color:rgb(51,51,51);">Die Geschäftsunterstützung, die von der MahaDasha-Gruppe bereitgestellt wird, wird von den Begünstigten gut aufgenommen, insbesondere von Sukardi, dem Leiter des Dorfes Petir.</p>',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa English ke Germany (Deutsch). Terjemahkan dengan grammar Germany (Deutsch), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
];