<?php

return [
    'en-plain'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah seorang ahli dalam tata bahasa Inggris.'
        ],
        [
            'role'=>'user',
            'content'=> 'Tolong koreksi kalimat berikut dengan grammar bahasa english yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa english. Perbaiki kalimat baku setelah titik dua berikut: Tahapan Rencana iB is a savings plan based on the principle of mudharabah muthlaqah to assist customers in financial planning.'
        ],
        [
            'role'=>'assistant',
            'content'=>'Tahapan Rencana iB is a savings plan based on the principle of mudharabah muthlaqah to assist customers in financial planning. Corrected: Tahapan Rencana iB is a savings plan based on the principle of mudharabah muthlaqah to assist customers in financial planning.'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa english yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa english. Perbaiki kalimat baku setelah titik dua berikut: [query]',
        ],
    ],
    'en-html'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah seorang ahli dalam tata bahasa Inggris.'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa English yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa English. Pertahankan tag html jangan diubah. Perbaiki kalimat baku setelah titik dua berikut:  <figure class="image">
                <img src="/cfind/source/images/pelaksanaan-survei-kepada-masyarakat-sekitar-untuk-hasil-program-kebun-gizi-1-1024x683.jpg">
            </figure>
            <h5 style="text-align:center;">
                <i>Implementation of Surveys to the Surrounding Community for the Results of the Nutritional Garden Program</i>
            </h5>
            <p>
                <br>
                <span style="background-color:rgb(255,255,255);color:rgb(51,51,51);">The business assistance provided by the MahaDasha Group is well-received by the beneficiaries, especially Sukardi, the Head of Petir Village.
            </span></p>'
        ],
        [
            'role' => 'assistant',
            'content' => '<figure class="image"> <img src="/cfind/source/images/pelaksanaan-survei-kepada-masyarakat-sekitar-untuk-hasil-program-kebun-gizi-1-1024x683.jpg"> </figure> <h5 style="text-align:center;"> <i>Implementation of Surveys to the Surrounding Community for the Results of the Nutritional Garden Program</i> </h5> <p> <br> <span style="background-color:rgb(255,255,255);color:rgb(51,51,51);">The business assistance provided by the MahaDasha Group is well-received by the beneficiaries, especially Sukardi, the Head of Petir Village.</span> </p>'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa English yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa English. Pertahankan tag html jangan diubah. Perbaiki kalimat baku setelah titik dua berikut: [query]',
        ],
    ],	
];