<?php

return [
    'en-plain'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah ahli copywriting dalam bahasa English dengan pengalaman membuat salinan yang lancar dan ringkas'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa english. buat copywriting dengan kisaran 55 sampai 65 kata berdasarkan topik utama setelah titik dua berikut: Pembukaan rekening online BCA Syariah memberikan kemudahan bagi nasabah untuk melakukan pembukaan rekening melalui aplikasi BCA Syariah Mobile kapan pun dan di mana pun.'
        ],
        [
            'role'=>'assistant',
            'content'=>'Experience the convenience of opening a BCA Syariah account online. With BCA Syariah Mobile app, customers can easily open an account anytime, anywhere. Enjoy seamless and secure banking services tailored to your needs. Start your journey towards financial freedom with BCA Syariah today.'
        ],
        [
            'role'=>'user',
            'content'=>'Please create copywriting in English with professional, fluent, and concise style, with a range of [start] to [end] words, based on the main topic after the following colon : [query]',
        ],
    ],
    'en-html'=>[
        [
            'role'=>'system',
            'content'=>'Anda adalah ahli copywriting dalam bahasa English dengan pengalaman membuat salinan yang lancar dan ringkas'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa english. Hasil dalam format HTML. buat copywriting dengan kisaran 55 sampai 65 kata berdasarkan topik utama setelah titik dua berikut: <p><span style="font-size:18px"><span style="color:#ff8c00"><strong>Manfaat</strong></span></span></p>
                <ul>
                        <li style="text-align:justify"><strong>Nyaman</strong>

                        <ul>
                                <li>Transaksi Tarik Tunai Cardless di seluruh ATM BCA.&nbsp;Simak langkahnya di <span style="font-size:16px"><strong><a href="/cardlessbcasyariah">sini</a></strong></span></li>
                                <li>Transaksi dapat dilakukan dimana saja tanpa harus mendatangi kantor cabang atau ATM</li>
                                <li>Transaksi dapat dilakukan kapan saja, tidak terbatas pada jam layanan kantor Bank*</li>
                                <li>Transaksi pembayaran QR di toko/<em>merchant</em> berlogo QRIS. Lihat infonya di <a href="/qris"><span style="font-size:14px"><strong>Sini</strong></span></a></li>
                                <li>Cukup satu fasilitas untuk mengakses seluruh rekening Anda (kecuali rekening dengan status&nbsp;<em>join account)</em></li>
                        </ul>
                        </li>
                </ul>'
        ],
        [
            'role'=>'assistant',
            'content'=>'<p><span style="font-size:18px"><span style="color:#ff8c00"><strong>Benefits</strong></span></span></p> <ul> <li style="text-align:justify"><strong>Convenience</strong> <ul> <li>Cardless Cash Withdrawal at all BCA ATMs. Follow the steps <span style="font-size:16px"><strong><a href="/cardlessbcasyariah">here</a></strong></span></li> <li>Transactions can be done anywhere without visiting a branch or ATM</li> <li>Transactions can be made anytime, not limited to bank office hours*</li> <li>QR payment transactions at stores/merchants with QRIS logo. Check details <a href="/qris"><span style="font-size:14px"><strong>here</strong></span></a></li> <li>One facility to access all your accounts (except accounts with join account status)</li> </ul> </li> </ul>'
        ],
        [
            'role'=>'user',
            'content'=>'Buat copywriting dalam bahasa english. Hasil dalam format HTML. buat copywriting dengan kisaran 55 sampai 65 kata berdasarkan topik utama setelah titik dua berikut: [query]',
        ],
    ],	
];