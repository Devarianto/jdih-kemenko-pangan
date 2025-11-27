<?php

return [
    'de-plain'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah ahli copywriting dalam bahasa Germany (Deutsch) dengan pengalaman membuat salinan yang lancar dan ringkas'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa Germany (Deutsch). buat copywriting dengan kisaran 55 sampai 65 kata berdasarkan topik utama setelah titik dua berikut: PT Bank BCA Syariah (BCA Syariah) berkolaborasi dengan BenihBaik.com melakukan aksi kepedulian lingkungan hidup “Satu Pohon Selamatkan Bumi”. Kegiatan dilakukan dalam bentuk penanaman 1.000 bibit durian bagi para petani di Desa Cibulao, Megamendung, Bogor, Jawa Barat.'
        ],
        [
            'role'=>'assistant',
            'content'=>'PT Bank BCA Syariah (BCA Syariah) hat sich mit BenihBaik.com zusammengetan, um die Umweltinitiative "Ein Baum rettet die Erde" umzusetzen. Die Aktion beinhaltet die Pflanzung von 1.000 Durian-Sämlingen für Bauern in Desa Cibulao, Megamendung, Bogor, Westjava.'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa Germany (Deutsch). buat copywriting dengan kisaran [start] sampai [end] kata, berdasarkan topik utama setelah titik dua berikut: [query]',
        ],
    ],
    'de-html'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah ahli copywriting dalam bahasa Germany (Deutsch) dengan pengalaman membuat salinan yang lancar dan ringkas'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa Germany (Deutsch). Hasil dalam format HTML. buat copywriting dengan kisaran 55 sampai 65 kata berdasarkan topik utama setelah titik dua berikut: <p style="text-align:justify"><span style="color:#36a5b2"><strong>Biaya Bank</strong></span></p>

            <p style="text-align:justify">Adalah biaya transaksi yang dilakukan melalui BCA Syariah <em>Mobile</em>&nbsp;termasuk apabila transaksi tersebut tidak berhasil dijalankan/diproses oleh Bank.</p>
            
            <div class="table">
            <table border="1" cellpadding="1" cellspacing="1">
                    <thead>
                            <tr>
                                    <th scope="col">KETERANGAN</th>
                                    <th scope="col">JUMLAH (IDR)</th>
                            </tr>
                    </thead>
                    <tbody>
                            <tr>
                                    <td><span style="font-size:14px">Transfer&nbsp;<em>Online&nbsp;</em>ke BCA</span></td>
                                    <td style="text-align:right"><span style="font-size:14px">Bebas Biaya</span></td>
                            </tr>
                            <tr>
                                    <td><span style="font-size:14px">Transfer&nbsp;<em>Online&nbsp;</em>ke Bank Lain</span></td>
                                    <td style="text-align:right"><span style="font-size:14px">6.500</span></td>
                            </tr>
                            <tr>
                                    <td><span style="font-size:14px">Transfer SKN ke Bank Lain</span></td>
                                    <td style="text-align:right"><span style="font-size:14px">2.900</span></td>
                            </tr>
                            <tr>
                                    <td><span style="font-size:14px">Transfer RTGS ke Bank Lain</span></td>
                                    <td style="text-align:right"><span style="font-size:14px">30.000</span></td>
                            </tr>
                            <tr>
                                    <td><span style="font-size:14px">Transfer BI Fast</span></td>
                                    <td style="text-align:right"><span style="font-size:14px">2.500</span></td>
                            </tr>
                            <tr>
                                    <td><span style="font-size:14px">Tarik Tunai Cardless</span></td>
                                    <td style="text-align:right"><span style="font-size:14px">Bebas biaya</span></td>
                            </tr>
                    </tbody>
            </table>
            </div>'
        ],
        [
            'role'=>'assistant',
            'content'=>'<p style="text-align:justify"><span style="color:#36a5b2"><strong>Bankgebühren</strong></span></p> <p style="text-align:justify">Sind die Transaktionskosten, die über BCA Syariah <em>Mobile</em> anfallen, auch wenn die Transaktion nicht erfolgreich von der Bank durchgeführt wird.</p> <div class="table"> <table border="1" cellpadding="1" cellspacing="1"> <thead> <tr> <th scope="col">BESCHREIBUNG</th> <th scope="col">BETRAG (IDR)</th> </tr> </thead> <tbody> <tr> <td><span style="font-size:14px">Online-Überweisung an BCA</span></td> <td style="text-align:right"><span style="font-size:14px">Kostenlos</span></td> </tr> <tr> <td><span style="font-size:14px">Online-Überweisung an andere Bank</span></td> <td style="text-align:right"><span style="font-size:14px">6.500</span></td> </tr> <tr> <td><span style="font-size:14px">SKN-Überweisung an andere Bank</span></td> <td style="text-align:right"><span style="font-size:14px">2.900</span></td> </tr> <tr> <td><span style="font-size:14px">RTGS-Überweisung an andere Bank</span></td> <td style="text-align:right"><span style="font-size:14px">30.000</span></td> </tr> <tr> <td><span style="font-size:14px">BI Fast-Überweisung</span></td> <td style="text-align:right"><span style="font-size:14px">2.500</span></td> </tr> <tr> <td><span style="font-size:14px">Cardless Bargeldabhebung</span></td> <td style="text-align:right"><span style="font-size:14px">Kostenlos</span></td> </tr> </tbody> </table> </div>'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa Germany (Deutsch). Hasil dalam format HTML. buat copywriting dengan kisaran [start] sampai [end] kata, berdasarkan topik utama setelah titik dua berikut:  [query]',
        ],
    ],
];