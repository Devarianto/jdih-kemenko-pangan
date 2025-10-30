<?php

return [
    'fr-plain'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah seorang ahli dalam tata bahasa France (Francais)'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa France (Francais) yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa France (Francais). Perbaiki kalimat baku setelah titik dua berikut: Assurez la qualité de la production auprès de fournisseurs vérifiés, avec vos commandes protégées du paiement à la livraison.'
        ],
        [
            'role'=>'assistant',
            'content'=>'Assurez la qualité de la production auprès de fournisseurs vérifiés : vos commandes sont protégées du paiement à la livraison.'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa France (Francais) yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa France (Francais). Perbaiki kalimat baku setelah titik dua berikut: [query]',
        ],
    ],
    'fr-html'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah seorang ahli dalam tata bahasa France (Francais)'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa France (Francais) yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa France (Francais). Pertahankan tag html jangan diubah. Perbaiki kalimat baku setelah titik dua berikut: <p><span style="font-size:18px"><span style="color:#ff8c00"><strong>Biaya</strong></span></span></p>

            <div class="table">
            <table border="1" cellpadding="0" cellspacing="0">
                    <thead>
                            <tr>
                                    <th scope="col">KETERANGAN</th>
                                    <th scope="col">JUMLAH (IDR)</th>
                            </tr>
                    </thead>
                    <tbody>
                            <tr>
                                    <td>Setoran Awal</td>
                                    <td style="text-align:right">100.000</td>
                            </tr>
                            <tr>
                                    <td>Setoran Fleksibel</td>
                                    <td style="text-align:right">Minimal 50.000</td>
                            </tr>
                            <tr>
                                    <td>Setoran Terjadwal</td>
                                    <td style="text-align:right">Minimal 50.000 dan berlaku kelipatan</td>
                            </tr>
                            <tr>
                                    <td>Biaya Administrasi Bulanan</td>
                                    <td style="text-align:right">0</td>
                            </tr>
                            <tr>
                                    <td>Biaya Penutupan Rekening</td>
                                    <td style="text-align:right">50.000</td>
                            </tr>
                    </tbody>
            </table>
            </div>
            <ul>
                    <li>Minimal Rp. 50.000 &amp; berlaku kelipatan Rp. 50.000</li>
                    <li>Tanggal pendebetan setoran adalah tanggal 1 s/d 28 setiap bulan</li>
                    <li>Bebas memilih jangka waktu setoran dengan mengisi formulir Transfer Otomatis</li>
                    <li>Pendebetan setoran dilakukan otomatis dari rekening induk di BCA Syariah dan tidak harus milik nasabah yang sama</li>
            </ul>'
        ],
        [
            'role'=>'assistant',
            'content'=>'<p><span style="font-size:18px"><span style="color:#ff8c00"><strong>Coûts</strong></span></span></p> <div class="table"> <table border="1" cellpadding="0" cellspacing="0"> <thead> <tr> <th scope="col">DESCRIPTION</th> <th scope="col">MONTANT (IDR)</th> </tr> </thead> <tbody> <tr> <td>Versement initial</td> <td style="text-align:right">100.000</td> </tr> <tr> <td>Versement flexible</td> <td style="text-align:right">Minimum 50.000</td> </tr> <tr> <td>Versement programmé</td> <td style="text-align:right">Minimum 50.000 et en multiples</td> </tr> <tr> <td>Frais d\'administration mensuels</td> <td style="text-align:right">0</td> </tr> <tr> <td>Frais de clôture de compte</td> <td style="text-align:right">50.000</td> </tr> </tbody> </table> </div> <ul> <li>Minimum Rp. 50.000 &amp; en multiples de Rp. 50.000</li> <li>La date de débit du dépôt est du 1er au 28 de chaque mois</li> <li>Libre choix de la périodicité du dépôt en remplissant le formulaire de Virement Automatique</li> <li>Le débit du dépôt est effectué automatiquement depuis le compte principal à BCA Syariah et n\'a pas besoin d\'appartenir au même client</li> </ul>'
        ],
        [
            'role'=>'user',
            'content'=>'Tolong koreksi kalimat berikut dengan grammar bahasa France (Francais) yang benar, dengan memperhatikan tanda baca yang benar. Perbaiki kalimat dalam baku bahasa France (Francais). Pertahankan tag html jangan diubah. Perbaiki kalimat baku setelah titik dua berikut: [query]',
        ],
    ],
];