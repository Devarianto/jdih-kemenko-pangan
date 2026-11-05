<script>
    let valueType = $('select[name="type"]').val();
    typeGallery(valueType);

    $(document).ready(function() {
        $('select[name="type"]').on('change', function() {
            let value = $(this).val();
            typeGallery(value);
        });

        $('.date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            endDate: new Date(),
            todayHighlight: true
        });
    });

    function typeGallery(value)
    {
        if (value == 'image') {
            $('div[origin="iframe"]').hide();
            $('div[origin="iframe"] input[name="iframe"]').removeClass('required');

            $('div[origin="classification"]').hide();

            $('div.widgets').show();
            $('div.widgets').attr('widget-min', 1);
            $('div.widgets input[origin="widget_image_title"]').addClass('required');
            $('div.widgets input[origin="widget_image_thumbnail"]').addClass('required');
            $('div.widgets input[origin="widget_image_image"]').addClass('required');
        } else {
            $('div[origin="iframe"]').show();
            $('div[origin="iframe"] input[name="iframe"]').addClass('required');

            $('div[origin="classification"]').show();

            $('div.widgets').hide();
            $('div.widgets').removeAttr('widget-min');
            $('div.widgets input[origin="widget_image_title"]').removeClass('required');
            $('div.widgets input[origin="widget_image_thumbnail"]').removeClass('required');
            $('div.widgets input[origin="widget_image_image"]').removeClass('required');
        }
    }
</script>