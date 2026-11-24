<script>
    $(document).ready(function() {
        $('.date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            endDate: new Date(),
            todayHighlight: true
        });

        // Quick Slide Generator: fill 1..N slides automatically without clicking +more one by one
        var $widgetTable = $('input[name^="widget_image"]').closest('.form-box, .box-body, table').first();
        if ($('a.more-row').length) {
            var $helper = $(
                '<div style="margin:10px 0 14px;padding:12px 15px;background:#f0f7ff;border:1px solid #bfd7ff;border-radius:6px;">' +
                '<strong><i class="fa fa-magic"></i> Quick Multi-Slide / Instagram Info:</strong> ' +
                '<div style="font-size:12px;color:#334155;margin-top:4px;">' +
                '1) <b>Cara Paling Cepat (Seperti YouTube):</b> Cukup pilih 1 <b>Thumbnail (Sampul)</b> dan tempelkan link Instagram (misal <code>https://www.instagram.com/p/DaebQhEmTzd/</code>) di dalam <b>Description</b>. Kosongkan baris Image Detail di bawah (klik tanda silang pada baris kosong), maka saat diklik di halaman publik akan langsung membuka Popup Carousel Instagram yang bisa di-slide!<br>' +
                '2) <b>Atau Auto-Isi Banyak File Slide Sekaligus:</b> Masukkan pola nama file di folder <code>images/infografis/</code> (misal prefix <code>perpres-14-2026-pascapanen-slide-</code> dan jumlah slide <code>8</code>): ' +
                '<span style="display:inline-flex;gap:6px;align-items:center;margin-top:6px;">' +
                '<input type="text" id="qs-prefix" placeholder="prefix-slide-" style="padding:3px 8px;border:1px solid #cbd5e1;border-radius:4px;width:220px;"> ' +
                '<input type="number" id="qs-count" placeholder="Jml" min="1" max="20" value="5" style="padding:3px 6px;border:1px solid #cbd5e1;border-radius:4px;width:60px;"> ' +
                '<input type="text" id="qs-ext" value=".jpg" style="padding:3px 6px;border:1px solid #cbd5e1;border-radius:4px;width:55px;"> ' +
                '<button type="button" id="qs-apply" class="btn btn-xs btn-primary" style="padding:4px 10px;">Auto-Isi Semua Slide</button>' +
                '</span></div></div>'
            );
            $('a.more-row').first().before($helper);

            $('#qs-apply').on('click', function() {
                var prefix = $.trim($('#qs-prefix').val());
                var count = parseInt($('#qs-count').val(), 10) || 0;
                var ext = $.trim($('#qs-ext').val()) || '.jpg';
                if (!prefix || count < 1) {
                    alert('Masukkan prefix nama file dan jumlah slide terlebih dahulu.');
                    return;
                }
                var $moreBtn = $('a.more-row').first();
                while ($('input[name^="widget_image_image["]').length < count) {
                    $moreBtn.trigger('click');
                }
                $('input[name^="widget_image_image["]').each(function(idx) {
                    if (idx < count) {
                        var fname = prefix + (idx + 1) + ext;
                        var jsonVal = JSON.stringify({
                            path: 'images/infografis/' + fname,
                            alt_id: '',
                            alt_en: ''
                        });
                        $(this).val(jsonVal).trigger('change');
                    }
                });
                alert('Berhasil mengisi ' + count + ' slide otomatis!');
            });
        }
    });
</script>