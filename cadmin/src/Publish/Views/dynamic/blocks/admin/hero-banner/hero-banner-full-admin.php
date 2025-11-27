<script>
	function herobannertypeselect(obj) {
		let parent = $(obj).parent().parent().parent();
		
		if($(obj).val() == 'video') {
			parent.find('input.form-control[cfind-type=image],input.form-control[origin$=subtitle],input.form-control[origin$=title],input.form-control[origin$=intro]').each(function() {
				$(this).parents('.form-group').hide();
				$(this).removeClass('required');
			});
			parent.find('input.form-control[cfind-type=file]').each(function() {
				$(this).parents('.form-group').show();
				$(this).addClass('required');
			});
			parent.find('.widgets[widget-source$=buttons] .widget-container').html('');
			parent.find('.widgets[widget-source$=buttons]').hide();
		} else {
			parent.find('input.form-control[cfind-type=file]').each(function() {
				$(this).parents('.form-group').hide();
				$(this).removeClass('required');
			});
			parent.find('input.form-control[cfind-type=image],input.form-control[origin$=subtitle],input.form-control[origin$=title],input.form-control[origin$=intro]').each(function() {
				$(this).parents('.form-group').show();
				$(this).addClass('required');
			});
			parent.find('.widgets[widget-source$=buttons]').show();
		}
	}
	$(document).on('change','select[origin=widget_hero-banner-full-banner_type]',function() {
		herobannertypeselect(this);
	});
	$('select[origin=widget_hero-banner-full-banner_type]').each(function() {
		herobannertypeselect(this);
	});

</script>