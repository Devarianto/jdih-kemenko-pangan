<?php

return [
    'fr-plain'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah ahli copywriting dalam bahasa France (Francais) dengan pengalaman membuat salinan yang lancar dan ringkas'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa France (Francais). buat copywriting dengan kisaran 55 sampai 65 kata berdasarkan topik utama setelah titik dua berikut: Dewan Komisaris adalah organ perusahaan yang bertugas melakukan pengawasan secara umum dan/atau khusus sesuai dengan anggaran dasar BCA Syariah serta memberi nasihat kepada Direksi sebagaimana dimaksud dalam Undang-Undang Nomor 40 Tahun 2007 tentang Perseroan Terbatas.'
        ],
        [
            'role'=>'assistant',
            'content'=>'Le Conseil d\'Administration est l\'organe de surveillance de l\'entreprise chargé de superviser généralement et/ou spécifiquement conformément aux statuts de BCA Syariah et de conseiller la Direction, tel que prévu dans la Loi n° 40 de 2007 sur les Sociétés à Responsabilité Limitée.'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa France (Francais). buat copywriting dengan kisaran [start] sampai [end] kata, berdasarkan topik utama setelah titik dua berikut: [query]',
        ],
    ],
    'fr-html'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah ahli copywriting dalam bahasa France (Francais) dengan pengalaman membuat salinan yang lancar dan ringkas'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa France (Francais). Hasil dalam format HTML. buat copywriting dengan kisaran 55 sampai 65 kata berdasarkan topik utama setelah titik dua berikut: <p style="text-align:justify"><span style="color:#36a5b2"><strong>Biaya Bank</strong></span></p>

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
            'content'=>'<p style="text-align:justify"><span style="color:#36a5b2"><strong>Frais Bancaires</strong></span></p> <p style="text-align:justify">Les frais de transaction effectués via BCA Syariah <em>Mobile</em> incluent les cas où la transaction échoue ou n\'est pas traitée par la banque.</p> <div class="table"> <table border="1" cellpadding="1" cellspacing="1"> <thead> <tr> <th scope="col">DESCRIPTION</th> <th scope="col">MONTANT (IDR)</th> </tr> </thead> <tbody> <tr> <td><span style="font-size:14px">Transfert en ligne vers BCA</span></td> <td style="text-align:right"><span style="font-size:14px">Gratuit</span></td> </tr> <tr> <td><span style="font-size:14px">Transfert en ligne vers une autre banque</span></td> <td style="text-align:right"><span style="font-size:14px">6.500</span></td> </tr> <tr> <td><span style="font-size:14px">Transfert SKN vers une autre banque</span></td> <td style="text-align:right"><span style="font-size:14px">2.900</span></td> </tr> <tr> <td><span style="font-size:14px">Transfert RTGS vers une autre banque</span></td> <td style="text-align:right"><span style="font-size:14px">30.000</span></td> </tr> <tr> <td><span style="font-size:14px">Transfert BI Fast</span></td> <td style="text-align:right"><span style="font-size:14px">2.500</span></td> </tr> <tr> <td><span style="font-size:14px">Retrait d\'argent sans carte</span></td> <td style="text-align:right"><span style="font-size:14px">Gratuit</span></td> </tr> </tbody> </table> </div>'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa France (Francais). Hasil dalam format HTML. buat copywriting dengan kisaran [start] sampai [end] kata, berdasarkan topik utama setelah titik dua berikut:  [query]',
        ],
    ],
];