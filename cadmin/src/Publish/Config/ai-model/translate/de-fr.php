<?php
//Germany (Deutsch) ke France (Francais)

return [
    'de-fr-plain'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan menterjemah dari bahasa Germany (Deutsch) ke France (Francais)',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Germany (Deutsch) ke France (Francais). Terjemahkan dengan grammar bahasa France (Francais), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : Kontaktieren Sie eine Vielzahl von Lieferanten mit unabhängig geprüften Qualifikationen und Fähigkeiten. Achten Sie auf das "Verified"-Logo, um erfahrene Lieferanten zu finden, auf die sich Ihr Unternehmen verlassen kann.',
        ],
        [
            'role'=>'assistant',
            'content'=>'Contactez une variété de fournisseurs avec des qualifications et compétences vérifiées de manière indépendante. Soyez attentif au logo "Vérifié" pour trouver des fournisseurs expérimentés sur lesquels votre entreprise peut compter.',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Germany (Deutsch) ke France (Francais). Terjemahkan dengan grammar bahasa France (Francais), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
    'de-fr-html'=>[
        [
            'role'=>'system',
            'content'=>'kamu adalah sistem AI yang memiliki kemampuan penterjemahan kalimat dalam format HTML, menterjemah dari bahasa Germany (Deutsch) ke France (Francais)',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Germany (Deutsch) ke France (Francais). Terjemahkan dengan grammar France (Francais), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : <p><span style="font-size:18px"><span style="color:#ff8c00"><strong>Anforderungen</strong></span></span></p>

            <ul>
                <li>Einzelperson (Indonesischer Staatsbürger)</li>
                <li>Fotokopie des Personalausweises (E-KTP) und der Steueridentifikationsnummer (NPWP)</li>
                <li>Speziell für die Kontoeröffnung für Kinder beifügen:
                    <ul>
                        <li>Familienbuch</li>
                        <li>Geburtsurkunde</li>
                        <li>Schülerausweis (falls vorhanden)</li>
                    </ul>
                </li>
            </ul>',
        ],
        [
            'role'=>'assistant',
            'content'=>'<p><span style="font-size:18px"><span style="color:#ff8c00"><strong>Exigences</strong></span></span></p> <ul> <li>Personne seule (citoyen indonésien)</li> <li>Copie du passeport (E-KTP) et du numéro d\'identification fiscale (NPWP)</li> <li>Pièces spécifiques à joindre pour l\'ouverture de compte pour les enfants : <ul> <li>Livret de famille</li> <li>Acte de naissance</li> <li>Carte d\'étudiant (si disponible)</li> </ul> </li> </ul>',
        ],
        [
            'role'=>'user',
            'content'=>'Terjemahkan dari bahasa Germany (Deutsch) ke France (Francais). Terjemahkan dengan grammar France (Francais), jelas dan mudah dipahami. Jangan terjemahkan singkatan atau akronim. Pertahankan tag html jangan diubah. Terjemahkan setelah tanda colon : [query]',
        ],
    ],
];