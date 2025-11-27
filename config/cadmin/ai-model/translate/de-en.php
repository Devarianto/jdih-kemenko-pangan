<?php
//Germany (Deutsch) ke English
return [
    'de-en-plain'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dari bahasa Germany (Deutsch) ke English',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Germany (Deutsch) ke English. Terjemahkan dengan grammar bahasa English, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : Wie wäre es mit einer Rundreise zu den Schlössern der Loire? Das Dornröschenschloss finden Sie in Ussé, das Schloss von Leonardo da Vinci in der Nähe von Amboise.
            Wir beobachten die Marder im Wald von Orléans und fahren die Loire mit dem Fahrrad hoch. Wir stehen erfürchtig vor dem Wandteppich "Zyklus der Apokalypse" in Angers und fahren bis Nantes weiter, wo wir die großen Maschinen und den Elefanten bewundern.',
        ],
        [
            'role'=>'assistant',
            'content'=>'How about taking a round trip to the castles of the Loire? You can find the Sleeping Beauty\'s Castle in Ussé, and Leonardo da Vinci\'s castle near Amboise. We observe the martens in the forest of Orléans and cycle up the Loire. We stand in awe in front of the tapestry "Cycle of the Apocalypse" in Angers and continue to Nantes, where we admire the large machines and the elephant.',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Germany (Deutsch) ke English. Terjemahkan dengan grammar bahasa English, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
    'de-en-html'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan penterjemahan kalimat dalam format HTML, menterjemah dari bahasa Germany (Deutsch) ke English',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Germany (Deutsch) ke English. Terjemahkan dengan grammar English, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : <p><span style="color:#ff8c00"><strong><span style="font-size:18px">Bareinzahlungs-Transaktionsfunktionen </span></strong></span></p>

            <ul>
                    <li>Der Saldo wird sofort auf das BCA Syariah-Konto übertragen</li>
                    <li>Kann Geldscheine im Wert von Rp50.000 und Rp100.000 annehmen</li>
                    <li>Maximaler Einzahlungsbetrag pro Transaktion beträgt 100 Scheine</li>
            </ul>',
        ],
        [
            'role'=>'assistant',
            'content'=>'<p><span style="color:#ff8c00"><strong><span style="font-size:18px">Cash deposit transaction functions</span></strong></span></p> <ul> <li>The balance is immediately transferred to the BCA Syariah account</li> <li>Can accept banknotes worth Rp50,000 and Rp100,000</li> <li>Maximum deposit amount per transaction is 100 banknotes</li> </ul>',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Germany (Deutsch) ke English. Terjemahkan dengan grammar English, jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
];