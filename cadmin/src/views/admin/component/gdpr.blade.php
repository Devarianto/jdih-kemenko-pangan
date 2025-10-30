<script>
    $(document).on('change', 'select[origin=gdpr]',function(e) {
        if ($(this).val() == "on") {
            $('div[origin="widget_embed-scripts_category"]').show();
        } else {
            $('div[origin="widget_embed-scripts_category"]').hide();
        }
    });

    $(document).ready(function() {
        $('select[origin=gdpr]').trigger('change');
    });
</script>