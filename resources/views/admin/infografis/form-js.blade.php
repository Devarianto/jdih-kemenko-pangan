<script>
    $(document).ready(function() {
        $('.date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            endDate: new Date(),
            todayHighlight: true
        });
    });
</script>