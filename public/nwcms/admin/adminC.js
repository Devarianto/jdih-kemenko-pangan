/* ============== VALIDATOR ======================================================== */

/* :example
<input class="form-control required unique" data-table='product' data-field='name' data-not="1">
*/

function escape_HTML(html_str) {
    if (!html_str)
        return '';

    return html_str.replace(/[&<>"]/g, function (tag) {
		var chars_to_replace = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '"'
        };

		return chars_to_replace[tag] || tag;
	});
}


$.validator.addMethod("unique",
    function(value, element) {
        var result = false;

        var table = $(element).attr('data-table');
        var field = $(element).attr('data-field');
        var not = $(element).attr('data-not');
		var module = $(element).attr('data-module');

        if (!table || !field) { return true; }

        var post = {table:table,field:field,value:value,not:not,module:module, _token:$token};

        if ($(element).attr('data-foreign')) {
            post.foreign = $(element).attr('data-foreign');
            post.foreignID = $($(element).attr('data-foreign-target')).val();
        }

        $.ajax({
            type:"POST",
            async: false,
            url: $url + '/validate/unique', // script to validate in server side
            data: post,
            success: function(data) {
                result = ($.trim(data) == 'true') ? true : false;
            }
        });

        return result;
    }, "This value is already taken! Try another."
);

$.validator.classRuleSettings.unique = { unique: true };

$.validator.addMethod("validEmail", function(value, element) {
    return this.optional(element) || /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(value);
}, "Please enter valid email.");

$.validator.classRuleSettings.validEmail = {validEmail: true};

$.validator.addMethod('uniqueAll',
	function(value, element) {
		var by = $(element).attr('data-unique-by');
		var that = $(element);
		var unique = false;
		if (!that.val())
			return true;

		$(by).each(function() {
			if ($(this).attr('name') == that.attr('name'))
				return;

			if ($(this).val() && $(this).val() == that.val())
				unique = true;
		});

		return unique == false;
	}, 'This value is already taken! Try another.'
);

$.validator.classRuleSettings.uniqueAll = { uniqueAll:true };

/* =============== CFIND ========================================================== */

var cfind = [];

cfind.url = $url;

cfind.afterSet = function(obj, json) {
    var cfind = {};
    if (json)
        cfind = JSON.parse(json);
	obj.parent().find('.cfind-tool').remove();

	if (obj.val()) {
        obj.removeClass('empty');
        obj.attr('ext',cfind.type);
		if (obj.attr('cfind-type') == 'image') {
			this.setImage(obj, cfind.path);
		}
		var tool = $('<div class="cfind-tool"></div>');
        tool.append('<i>filename : ' + cfind.path.split('/').reverse()[0] + '</i>');
		if (!obj.hasClass('required') && !obj.attr('cfind-disable')) {
			tool.append('<a href=# class="cfind-clear fa fa-trash-o"></a>');
		}
		tool.append('<a href=# class="cfind-download fa fa-download"></a>');

        if (obj.attr('cfind-alt')) {

			tool.append('<div class="cfind-alt-container"></div>');
            tool.find('.cfind-alt-container').append('<i class="fa fa-info"></i>');

			$('.sticky-lang ul li a').each(function() {
				var lang = $(this).attr('toggle-target').replace('-container','');

				if (obj.attr('cfind-disable')) {
					var alt = $('<span style="display:block;margin-left:20px;" class="toggle-target lang-target-container" toggle-target="' + lang + '-container">' + escape_HTML(cfind['alt_' + lang]) + '</span>');
				} else {
					var alt = $('<input type="text"  name="alt_' + lang + '" class="cfind-alt toggle-target lang-target-container" info="alt text" toggle-target="' + lang + '-container">');
					alt.val(cfind['alt_' + lang]);
				}
				if ($(this).hasClass('active'))
					alt.css('display','block');
				else
					alt.css('display','none');
				tool.find('.cfind-alt-container').append(alt);
			});
        }

		obj.parent().append(tool);
	} else {
		obj.addClass('empty');
        obj.removeAttr('style');
	}

    if (cfind && obj.attr('cfind-type') == 'image' &&
       (cfind['image-width'] < 300 && cfind['image-height'] < 110)) {
        obj.css('background-size','auto');
    } else {
        obj.css('background-size','contain');
    }
}

cfind.set = function(cfind) {
    this.obj.val(cfind);
    this.obj.parent().parent().find('.cfind-alt').val('');
	this.afterSet(this.obj,cfind);
}

cfind.setImage = function(obj, path) {
    obj.css('background-image', 'url("' + $mediaPath + '/' + path + '")');
}

cfind.reset = function()
{
    $('input[type=text].cfind').each(function() {
        $(this).attr('readonly', 'readonly');
		cfind.afterSet($(this), $(this).val());
    });
}

cfind.reset();

$('body').on('click', 'input[type=text].cfind', function() {
    if ($(this).attr('cfind-disable')) return false;

    cfind.obj = $(this);

    type = $(this).attr('cfind-type');
    if (!type) type = 'image';

	var url = cfind.url + '/' + type + '?opener=cfind';

	if ($(this).attr('cfind-ext'))
		url += '&ext=' + $(this).attr('cfind-ext');

	if ($(this).attr('cfind-thumb'))
        url += '&thumb=' + $(this).attr('cfind-thumb');
	if ($(this).attr('cfind-convert'))
		url += '&convert=' + $(this).attr('cfind-convert');

    window.open(url, 'Cfind', 'toolbar=0,status=0,width=1200,height=600');
    return false;
});

$('body').on('click', 'a.cfind-clear', function() {
	var obj = $(this).parent().parent().find('.cfind');
	obj.each(function() {
		$(this).val('');
	});

	cfind.afterSet(obj);

	return false;
});

$('body').on('click', 'a.cfind-download', function() {
	var obj = $(this).parent().parent().find('.cfind');
	if (!obj.val()) {
		$(this).hide();
		return false;
	}

    var cfind = JSON.parse(obj.val());
	var url = $mediaPath + '/' + cfind.path;

	window.open(url, '_blank');

	return false;
});

$('body').on('change','input.cfind-alt',function() {
    var obj = $(this).parent().parent().parent().find('.cfind');

    var json = {};
    if (obj.val())
        json = JSON.parse(obj.val());

    json[$(this).attr('name')] = $(this).val();
    obj.val(JSON.stringify(json));
});


/* ========================= BULK CHECK ============================== */

$('input.check-all').on('click', function() {console.log($(this).is(':checked'));
    var target = $(this).attr('target');
	if ($(this).is(':checked')) {
		$(target).each(function() {
        if (!$(this).is(':checked')) {
            $(this).prop('checked',true);
        }
    });
	} else {
		$(target).each(function() {
			if ($(this).is(':checked')) {
				$(this).prop('checked',false);
			}
		});
	}
});

$('.table-responsive .bulk-check').on('ifChecked', function() {
    $(this).parents('tr').addClass('selected');
});

$('.table-responsive .bulk-check').on('ifUnchecked', function() {
    $(this).parents('tr').removeClass('selected');
});

/* ======================= ETC ============================ */

$(document).on('click', '.need-confirm', function() {
    var msg = $(this).attr('data-confirm');
    if (!msg) msg = 'Are you sure to continue?';

    return confirm(msg);
});


/* ======================== FORM INJECT VALIDATION ====================================== */

$('.form-validate').each(function() {
	$(this).validate({
		ignore:'.ck',
		invalidHandler: function(form, validator) {
			$.each(validator.errorList, function(k, v) {
				var container = $(this.element).parents('.toggle-target');
				if (container.attr('toggle-target')) { //if inside toggle target, show container
					var actor = $('.toggle-actor[toggle-target=' + container.attr('toggle-target') + ']');
					if (actor.is('[toggle-group]')) {
						actor.trigger('click');
						return false;
					}

					if ($(this.element).is(':hidden')) {
						actor.trigger('click');
						return false;
					}
				}
			});
		},
		submitHandler: function() {
			$('.numeric').each(function() {
				if (!$(this).hasClass('numeric-formated'))
					return;
				$(this).val(string2num($(this).val()));
			});

			return true;
		}
	});
	
	$.extend($(this).validate().settings, {
		onkeyup: false,
		onfocusout: false
	});
});



/* ============================== CKEDITOR ============================= */

var removeUrlHash = function()
{
	var loc = window.location.href,
    index = loc.indexOf('#');

	if (index > 0) {
		history.pushState("", document.title, loc.substring(0, index));
	}
}

let editors = [];
var ckeditorReset = function()
{
	$('.form-validate .ckeditor').each(function() {
		if ($(this).hasClass('has-ckeditor'))
			return;
		var id = $(this).attr('id');
		if (!$(this).attr('id')) {
			id = 'ckeditor_' + uniqid();
			$(this).attr('id', id);
		}
		
		ClassicEditor.create( document.querySelector( '#' + id ),{
			simpleUpload: {
				// The URL that the images are uploaded to.
				uploadUrl: $url + '/ckeditor/upload',

				// Enable the XMLHttpRequest.withCredentials property.
				withCredentials: true,

				// Headers sent along with the XMLHttpRequest to the upload server.
				headers: {
					'X-CSRF-TOKEN': $token,
				},
			},
			heading: {
				options: [
					{ model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
					{ model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
					{ model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
					{ model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
					{ model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
					{ model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
				]
			},
		}).then(function(editor) {
			$('.ckeditor#' +id).addClass('has-ckeditor');
			editors[id] = editor;
			editor.model.document.on('change:data', () => {
            	$('.ckeditor#' +id).val(editor.getData());
			});
		});
	});
}


/* ======================== RUN JS ================================= */

/*var loc = window.location.href,
    index = loc.indexOf('#');

if (index > 0) {
  window.location = loc.substring(0, index);
}*/

function aiPosition() 
{
	$('.form-validate .btn-ai').each(function() {
		if ($(this).css('display') != 'none')
			return;
		
		let space = 40;
		let input = $(this).parent().find('.form-control');
		if (input.hasClass('cfind') || input.outerWidth() <= 0)
			return;
		
		if (input.hasClass('ckeditor') || input.hasClass('my-ckeditor')){
			$(this).addClass('ai-ckeditor');
			$(this).css('top','40px');
			// space = 0;
		}else
			input.css('padding-right','40px');
		$(this).css('left',(input.outerWidth() - space) + 'px');
		$(this).show();
	});
}

function formLoad()
{
	if ($('.lang-target-container').length < 1 || $('.sticky-lang').find('.toggle-actor').length <= 1) {
		$('.sticky-lang').hide();
        $('.copy-translation').hide();
	} else {
		$('.sticky-lang').show();
        $('.copy-translation').show();
	}

    $('.datepicker').each(function() {
        if ($(this).val() == '0000-00-00')
            $(this).val('');
    });

    $('form .datepicker').datepicker({ format:'yyyy-mm-dd', autoclose:true });
    $('form .select2').select2();
    $('form .numeric').numeric();

    $('form .date-range-picker').daterangepicker({ 
		opens: "left",
		autoUpdateInput: false,
		locale: {
          cancelLabel: 'Clear'
		}
	});
	
	$('form .date-range-picker').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
	});

	$('form .date-range-picker').on('cancel.daterangepicker', function(ev, picker) {
	  $(this).val('');
	});
	
	aiPosition();
}

$(document).ready(function() {
	formLoad();
	ckeditorReset();

	//load logo
	$('.be-load-logo').each(function(k,v){
		const bg = $(v).data('logo');
		if(bg){
			$(v).css('background-image', 'url('+bg+')');
		}
	});
});

$('.sticky-lang a.toggle-actor').on('set', function() {
	if (!$(this).hasClass('active'))
		return;
	var lang = $(this).html();
	$('.lang-target-container[toggle-target=' + $(this).attr('toggle-target') + ']').each(function() {
		var labelContainer = $(this).parent().parent().find('> label.control-label');
		if (labelContainer.find('span.info.info-lang').length < 1)
			labelContainer.append('&nbsp;<span class="info info-lang"></span>');

		if ($('.sticky-lang').find('.toggle-actor').length > 1)
			labelContainer.find('> span.info.info-lang').html('( ' + lang + ' )');

		$('.sticky-lang > span > em').html(lang);
	});

	$('.sticky-lang').find('a.toggle-actor').removeClass('active');
	$(this).addClass('active');

	$('.sticky-lang').css('width', ($('.sticky-lang > ul').width() + 30) + 'px');
}).on('click', function() {
	$(this).trigger('set');
	aiPosition();
}).trigger('set');

/* ============== AI ============================== */
var modalTranslate = $('#ai-box-translate-confirm');
var modalTranslateUse = $('#ai-box-translate-use');
var confirmPrepareCkeditor, usePrepareCkeditor, useResultCkeditor;
let aiLabel = [];
let aiQuery = '';

$(document).on('click','.btn-ai',function() {
	$('.ai-items').hide();
	$(this).parent().find('.ai-items').show();
});
$(document).on('click',function(e) {
	if(!$(e.target).closest('.btn-ai').length){
		$('.ai-items').hide();
	}
});

$(document).on('click','.ai-translate',async function() {
	
	let input = $(this).parent().parent().parent().find('.form-control');
	let lang = {from:$(this).attr('data-translate-from'), to:input.attr('lang')};
	let source;

    /* Check if widget */
    if (input.attr('name').includes('widget')) {
        let inputName = input.attr('name');
        
        let widgetKey = inputName.match(/\[([^[\]]+)\]/);
        source = $('.form-control[name="'+ input.attr('origin') + '_' + lang.from +'[' + widgetKey[1] + ']"][origin=' + input.attr('origin') + '][lang=' + lang.from + ']');
    } else {
        source = $('.form-control[origin=' + input.attr('origin') + '][lang=' + lang.from + ']');
    }
	
	let q = source.val();
	let ckeditor = source.hasClass('ckeditor');
	if (ckeditor) {
		q = editors[source.attr('id')].getData();
	}

	let title = $(this).text();
	let confirmModal = await confirmModalTranslate(ckeditor, title, q);

	if(!confirmModal) //confirm translate
		return;
	
	$('.ai-items').hide();
	$('.ai-loader').css('display','flex');
	
	$.ajax({
		url:$url + '/ai/translate',
		method:'post',
		dataType:'json',
		timeout:0,
		data:{_token:$token,q:aiQuery,type:ckeditor ? 'html' : 'plain',lang:lang},
		success: async function(json) {
			if (json.status != 200) {
				alert(json.errors.join('. '));
				return;
			}
			//jika sukses buka modal use translate
			await confirmModalTranslateUse(title, input, json.data, aiQuery);
		},
		error:function() {
			alert('something went wrong, please try again later');
		},
		complete:function() {
			$('.ai-loader').hide();
		}
	});
});

$(document).on('click','.ai-meta-description', async function() {
	let qs = [];

	let target = $(this).parent().parent().parent().find('.form-control');
	let lang = target.attr('lang');
	
	$('.form-control[data-ai-meta-description=meta-description]').each(function() {
		let source = $(this);
		if (source.attr('lang') && source.attr('lang') != lang)
			return;
		let val = source.val().replace(/<[^<>]*>/gi, "");
		let ckeditor = source.hasClass('ckeditor');
		if (ckeditor) {
			if (editors[source.attr('id')]) {
				val = editors[source.attr('id')].getData().replace(/<[^<>]*>/gi, "");
			}
		}
		if (!val)
			return;
		qs.push(val);
		//get input label
		let label = $(this).parents('.form-group').find('.control-label').text();
		let widgetLabel = $(this).parents('.form-group').find('.control-label').parents('.form-group').attr('origin');
		if (widgetLabel.includes('widget')) {
			let widgetParts = widgetLabel.split("_");
			let sectionLabel = document.querySelector(`[origin="${widgetParts[1]}"]`).textContent;
			label = sectionLabel + " - " + label;
		}
		if(label){
			let arr = {
				value : val,
				text : label
			};
			aiLabel.push(arr);
		}
	});
	
	let q = qs.join('. ');
	
	let title = $(this).text();
	let confirmModal = await confirmModalTranslate(false, title, '', 'Suggest', 'Pilih bagian yang akan dijadikan meta description');

	if(!confirmModal) //confirm translate
		return;

	$('.ai-items').hide();
	$('.ai-loader').css('display','flex');
	
	$.ajax({
		url:$url + '/ai/meta-description',
		method:'post',
		dataType:'json',
		timeout:0,
		data:{_token:$token,q:aiQuery,baselang:lang},
		success:async function(json) {
			
			if (json.status != 200) {
				alert(json.errors.join('. '));
				return;
			}
			//jika sukses buka modal use translate
			await confirmModalTranslateUse(title, target, json.data, aiQuery, 'Use Suggestion');
		},
		error:function() {
			alert('something went wrong, please try again later');
		},
		complete:function() {
			$('.ai-loader').hide();
		}
	});
});

$(document).on('click','.ai-meta-title', async function() {
	let qs = [];

	let target = $(this).parent().parent().parent().find('.form-control');
	let lang = target.attr('lang');
	
	$('.form-control[data-ai-meta-title=meta-title]').each(function() {
		let source = $(this);
		if (source.attr('lang') && source.attr('lang') != lang)
			return;
		let val = source.val().replace(/<[^<>]*>/gi, "");
		let ckeditor = source.hasClass('ckeditor');
		if (ckeditor) {
			if (editors[source.attr('id')]) {
				val = editors[source.attr('id')].getData().replace(/<[^<>]*>/gi, "");
			}
		}
		if (!val)
			return;
		qs.push(val);
		//get input label
		let label = $(this).parents('.form-group').find('.control-label').text();
		let widgetLabel = $(this).parents('.form-group').find('.control-label').parents('.form-group').attr('origin');
		if (widgetLabel.includes('widget')) {
			let widgetParts = widgetLabel.split("_");
			let sectionLabel = document.querySelector(`[origin="${widgetParts[1]}"]`).textContent;
			label = sectionLabel + " - " + label;
		}
		if(label){
			let arr = {
				value : val,
				text : label
			};
			aiLabel.push(arr);
		}
	});
	
	let q = qs.join('. ');

	let title = $(this).text();
	let confirmModal = await confirmModalTranslate(false, title, '', 'Suggest');

	if(!confirmModal) //confirm translate
		return;
	
	$('.ai-items').hide();
	$('.ai-loader').css('display','flex');
	
	$.ajax({
		url:$url + '/ai/meta-title',
		method:'post',
		dataType:'json',
		timeout:0,
		data:{_token:$token,q:aiQuery,baselang:lang},
		success: async function(json) {
			
			if (json.status != 200) {
				alert(json.errors.join('. '));
				return;
			}
			//jika sukses buka modal use translate
			await confirmModalTranslateUse(title, target, json.data, aiQuery, 'Use Suggestion');
		},
		error:function() {
			alert('something went wrong, please try again later');
		},
		complete:function() {
			$('.ai-loader').hide();
		}
	});
});

$(document).on('click','.ai-meta-keyword', async function() {
	let qs = [];
	
	let target = $(this).parent().parent().parent().find('.form-control');
	let lang = target.attr('lang');
	
	$('.form-control[data-ai-meta-keyword=meta-keyword]').each(function() {
		let source = $(this);
		if (source.attr('lang') && source.attr('lang') != lang)
			return;
		let val = source.val().replace(/<[^<>]*>/gi, "");
		let ckeditor = source.hasClass('ckeditor');
		if (ckeditor) {
			if (editors[source.attr('id')]) {
				val = editors[source.attr('id')].getData().replace(/<[^<>]*>/gi, "");
			}
		}
		if (!val)
			return;
		qs.push(val);
		//get input label
		let label = $(this).parents('.form-group').find('.control-label').text();
		let widgetLabel = $(this).parents('.form-group').find('.control-label').parents('.form-group').attr('origin');
		if (widgetLabel.includes('widget')) {
			let widgetParts = widgetLabel.split("_");
			let sectionLabel = document.querySelector(`[origin="${widgetParts[1]}"]`).textContent;
			label = sectionLabel + " - " + label;
		}
		if(label){
			let arr = {
				value : val,
				text : label
			};
			aiLabel.push(arr);
		}
	});
	
	let q = qs.join('. ');

	let title = $(this).text();
	let confirmModal = await confirmModalTranslate(false, title, '', 'Suggest', 'Pilih bagian yang akan dijadikan meta keyword');

	if(!confirmModal) //confirm translate
		return;
	
	$('.ai-items').hide();
	$('.ai-loader').css('display','flex');
	
	$.ajax({
		url:$url + '/ai/meta-keyword',
		method:'post',
		dataType:'json',
		timeout:0,
		data:{_token:$token,q:aiQuery,baselang:lang},
		success: async function(json) {
			
			if (json.status != 200) {
				alert(json.errors.join('. '));
				return;
			}

			await confirmModalTranslateUse(title, target, json.data, aiQuery, 'Use Suggestion');
		},
		error:function() {
			alert('something went wrong, please try again later');
		},
		complete:function() {
			$('.ai-loader').hide();
		}
	});
});

let aiRequestor = null;
$(document).on('click','.ai-content',function() {
	aiRequestor = $(this).parent().parent().parent().find('.form-control');
	$('.ai-items').hide();
	
	$('#ai-content.ai-content-box').css('display','flex');
	$('#ai-content.ai-content-box textarea').focus();
	$('#ai-content.ai-content-box textarea').val('');
	$('#ai-content .ai-content-form').find('input[name=ai_content_maxlength]').val(300);
	modalTranslateUse.find('.fieldSelections').hide();
});

$('#ai-content .ai-content-form').validate({
	submitHandler: function() {
		if(aiRequestor.val().replace(/<[^<>]*>/gi, "") && confirm('your text is not empty, replace it?') != true)
			return;
		
		let lang = aiRequestor.attr('lang');
		if (!lang)
			lang = $lang; //get default
		
		let type = aiRequestor.hasClass('ckeditor') || aiRequestor.hasClass('my-ckeditor') ? 'html' : 'plain';
		let q = $('#ai-content .ai-content-form').find('textarea[name=ai_content_topic]').val();
		let words = $('#ai-content .ai-content-form').find('input[name=ai_content_maxlength]').val();
		$('.ai-loader').css('display','flex');
		
		$.ajax({
			url:$url + '/ai/content',
			method:'post',
			dataType:'json',
			timeout:0,
			data:{_token:$token,q:q,lang:lang,type:type,word:words},
			success: async function(json) {
				if (json.status != 200) {
					alert(json.errors.join('. '));
					return;
				}
				
				$('#ai-content.ai-content-box').hide();
				
				await confirmModalTranslateUse('Suggest Content from Topic', aiRequestor, json.data, q, 'Use Suggestion');
				
			},
			error:function() {
				alert('something went wrong, please try again later');
			},
			complete:function() {
				$('.ai-loader').hide();
			}
		});
		
		return false;
	}
});

$(document).on('click','.ai-correction', async function() {
	let target = $(this).parent().parent().parent().find('.form-control');
	let lang = target.attr('lang');

	let title = $(this).text();
	let q = target.val();
	let ckeditor = target.hasClass('ckeditor');
	if (ckeditor) {
		q = editors[target.attr('id')].getData();
	}
	let confirmModal = await confirmModalTranslate(ckeditor, title, q, 'Correction');

	if(!confirmModal) //confirm translate
		return;
	
	$('.ai-items').hide();
	$('.ai-loader').css('display','flex');
	
	$.ajax({
		url:$url + '/ai/correction',
		method:'post',
		dataType:'json',
		timeout:0,
		data:{_token:$token,q:aiQuery,lang:lang,type:ckeditor ? 'html' : 'plain'},
		success: async function(json) {
			
			if (json.status != 200) {
				alert(json.errors.join('. '));
				return;
			}

			await confirmModalTranslateUse(title, target, json.data, aiQuery, 'Use Correction');
		},
		error:function() {
			alert('something went wrong, please try again later');
		},
		complete:function() {
			$('.ai-loader').hide();
		}
	});
});

$(document).on('click', '#ai-content .ai-content-cancel',function() {
	$('.ai-content-box').hide();
});

async function confirmModalTranslate(ckeditor, title, text, btnLabel = 'Translate', optLabel = 'Pilih bagian yang akan dijadikan meta title'){
	modalTranslate.css('display', 'flex');
	modalTranslate.find('.fieldSelections').hide();
	modalTranslateUse.find('.fieldSelections').hide();
	modalTranslate.find('.ai-box-title').text(title);
	modalTranslate.find('.ai-btn-action[data-action=translate]').text(btnLabel);

	if(modalTranslate.find('textarea.ai-prepare-text').hasClass('has-ckeditor')){
		confirmPrepareCkeditor.destroy();
		modalTranslate.find('textarea.ai-prepare-text').removeClass('has-ckeditor');
	}

	modalTranslate.find('#ai-info-field').empty();	

	if(aiLabel.length > 0){
		modalTranslate.find('.fieldSelections').show();
		modalTranslateUse.find('.fieldSelections').show();
		$('select[name=fieldSelected]').empty().append('<option value="">'+optLabel+'</option>');
		aiLabel.forEach(function(v,i){
			var o = new Option(v.text, v.value);
			/// jquerify the DOM object 'o' so we can use the html method
			$(o).html(v.text);
			$('select[name=fieldSelected]').append(o);
		});
		modalTranslateUse.find('select[name=fieldSelected]').prop('disabled', true);
		aiLabel = [];
	}
	
	if (ckeditor) { //has ckeditor
		modalCkeditorInisialize('ai-confirm-textarea-prepare', text);
	}else{ //plain
		modalTranslate.find('textarea.ai-prepare-text').val(text);
	}

	if(!text || !text.replace(/<[^<>]*>/gi, "")){
		modalTranslate.find('label[for=ai-confirm-textarea-prepare]').css('display', 'block');
	}else{
		modalTranslate.find('label[for=ai-confirm-textarea-prepare]').hide();
	}

	let confirm = await confirmModalTranslateAction();
	return confirm;
}

function confirmModalTranslateAction(){
	return new Promise((resolve, reject) => {
		modalTranslate.find('.ai-btn-action').on('click', function(e){
			let qS = modalTranslate.find('textarea.ai-prepare-text').val();
			if(modalTranslate.find('textarea.ai-prepare-text').hasClass('has-ckeditor')){
				qS = confirmPrepareCkeditor.getData();
			}
			if(!qS || !qS.replace(/<[^<>]*>/gi, "")){
				return;
			}
			let action = $(this).data('action');
			if(action == 'cancel'){
				resolve(false)
			}
			if(action == 'translate'){
				aiQuery = qS;
				modalTranslate.hide();
				resolve(true)
			}
			resolve(false)
		});
		modalTranslate.find('.ai-content-cancel').on('click',function() {
			$('.ai-content-box').hide();
			resolve(false);
		});
		modalTranslate.find('select[name=fieldSelected]').on('change',function() {
			modalTranslate.find('textarea.ai-prepare-text').val($(this).val()).trigger('input');
			modalTranslateUse.find('select[name=fieldSelected]').val($(this).val());
		});
	})
}

async function confirmModalTranslateUse(title, input, data, q, btnLabel = 'Use Translate'){
	modalTranslateUse.css('display', 'flex');
	modalTranslateUse.find('.ai-box-title').text(title);
	modalTranslateUse.find('.ai-btn-action[data-action=use]').text(btnLabel);

	//destory if ckeditor
	if(modalTranslateUse.find('textarea.ai-prepare-text').hasClass('has-ckeditor')){
		usePrepareCkeditor.destroy();
		useResultCkeditor.destroy();
		modalTranslateUse.find('textarea.ai-prepare-text').removeClass('has-ckeditor');
	}

	if(input.hasClass('ckeditor')){
		modalCkeditorInisialize('ai-use-textarea-prepare', q);
		modalCkeditorInisialize('ai-use-textarea-result', data.text);
	}else{
		modalTranslateUse.find('#ai-use-textarea-prepare').val(q);
		modalTranslateUse.find('#ai-use-textarea-result').val(data.text);
	}
	modalTranslateUse.find('#ai-result-token').text(data.aiToken);
	modalTranslateUse.find('#ai-result-idr').text(data.webarqToken);

 	let confirm = await confirmModalTranslateUseAction();

	if(confirm){
		input.val(modalTranslateUse.find('#ai-use-textarea-result').val());
		if(input.hasClass('ckeditor')){
			editors[input.attr('id')].setData(useResultCkeditor.getData());
		}
		input.trigger('change');
	}
}

function confirmModalTranslateUseAction(){
	return new Promise((resolve) => {
		modalTranslateUse.find('.ai-btn-action').on('click', function(){
			let action = $(this).data('action');
			if(action == 'cancel'){
				resolve(false)
			}
			if(action == 'use'){
				modalTranslateUse.hide();
				resolve(true)
			}
			resolve(false)
		});
		modalTranslateUse.find('.ai-content-cancel').on('click',function() {
			$('.ai-content-box').hide();
			resolve(false);
		});
	})
}

function modalCkeditorInisialize(id, text){
	if($('#' + id).data('readonly')){ //jika ckeditor hanya bisa dilihat tanpa di edit
		ClassicEditor.create( document.querySelector( '#' + id ), {
			toolbar: [],
			isReadOnly: true
		})
		.then(function (editor){
			editor.setData(text);
			editor.enableReadOnlyMode("editor");
			$('#' +id).addClass('has-ckeditor');
			if(id == 'ai-use-textarea-prepare'){
				usePrepareCkeditor = editor;
			}
		});

		return;
	}
	ClassicEditor.create( document.querySelector( '#' + id ), {
		simpleUpload: {
			// The URL that the images are uploaded to.
			uploadUrl: $url + '/ckeditor/upload',

			// Enable the XMLHttpRequest.withCredentials property.
			withCredentials: true,

			// Headers sent along with the XMLHttpRequest to the upload server.
			headers: {
				'X-CSRF-TOKEN': $token,
			},
		},
		heading: {
			options: [
				{ model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
				{ model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
				{ model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
				{ model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
				{ model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
				{ model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
			]
		},
	})
	.then(function (editor){
		$('#' + id).addClass('has-ckeditor');
		editor.setData(text);
		editor.plugins.get( 'SourceEditing' ).isEnabled = false;
		if(id == 'ai-confirm-textarea-prepare'){
			confirmPrepareCkeditor = editor;
		}
		if(id == 'ai-use-textarea-result'){
			useResultCkeditor = editor;
		}
	});
}

$(document).on('input', 'textarea.ai-prepare-text',function(){
	let qS = $(this).val();
	if(qS || qS.replace(/<[^<>]*>/gi, "")){
		modalTranslate.find('label[for=ai-confirm-textarea-prepare]').css('display', 'none');
		return;
	}
	modalTranslate.find('label[for=ai-confirm-textarea-prepare]').css('display', 'block');
});

/* ============== STICKYS ON FORM ========================== */

// $('.sticky-lang > span').click(function() {
// 	$(this).parent().find('ul').show();
// });

// $('.sticky-lang').mouseleave(function() {
// 	$(this).find('ul').hide();
// });

$('.sticky-title').on('set', function() {
	var html = striptags($('.box-title').html());

	var subtitle = '';
	$('.form-subtitle').each(function() {
		if (!$(this).is(':visible'))
			return;
		var offsetTop = $(this).offset().top;
		if ($(window).scrollTop() >= offsetTop) {
			subtitle = striptags($(this).html());
		}
	});

	if (subtitle)
		html += ' / ' + subtitle;

	$(this).find('span > em').html(html);
}).trigger('set');

$(document).ready(function() {
	var offsetTopLang = $('.stickys').offset() ? $('.stickys').offset().top : 0;

	function stickys()
    {
		if ($('.stickys').length <=0)
			return;
		if ($(window).scrollTop() >= offsetTopLang) {
            //$('.stickys').parents('.box-body').addClass('scrolled');
			//$('.stickys').css('width', $('.box-body').width() + 20 + 'px');
			$('.stickys').css('top',($(window).scrollTop() - $('.box-primary').offset().top) + 'px');
		} else {
            //$('.stickys').parents('.box-body').removeClass('scrolled');
			//$('.stickys').css('width', '100%');
			$('.stickys').css('top','0px');
        }

		$('.sticky-title').trigger('set');
    }

    $(window).scroll(function() {
        stickys();
    });
	stickys();

	//ai content maxlength
	$('input[name=ai_content_maxlength]').inputFilter(function(value) {
		return /^\d*$/.test(value);    // Allow digits only, using a RegExp
	},"Only number allowed");
});

/* ============== FORMS ============== */

$(document).ready(function() {

	/* ============== WIDGETS ============== */	
	
	function widgetAdd(obj)
	{
        var source = obj.attr('widget-source');
        var el = $('.widget-source[widget-source="' + source + '"]').clone();

        obj.find('> .widget-container').append('<div class="widget-row">' + el.html() + '</div>');
        widgetLimit(obj);
        widgetIdx();

        $('.toggle-actor.active').trigger('click');
        setTimeout(function() { formLoad(); ckeditorReset(); }, 100);
	}
	
	function widgetLimit(obj)
	{
	    var limit = parseInt(obj.attr('widget-max'));
        var len = parseInt(obj.find('> .widget-container > .widget-row').length);
        if  (limit < 1)
            return;

        if (len >= limit)
            obj.find('> .widget-add').hide();
        else
            obj.find('> .widget-add').show();
	}
	
	function widgetIdx()
	{
        $('.box-body').find('> .widgets > .widget-container > .widget-row').each(function() { //parent only
            var id = uniqid();
            $(this).find('.widget-id').val(id);
        });
        
		$('.widget-row').each(function(k,v) {
			if ($(this).hasClass('widget-idx'))
                return;
            
            $(this).addClass('widget-idx');
            var unique = uniqid();
			
			$(this).find('[name$="[]"]').each(function(kk, vv) {
				$(this).attr('name', $(this).attr('name').replace('[]', '[' + unique + ']'));
			});
		});
	}
	
    widgetIdx();
    
	$(document).on('click', '.widget-add', function() {
		var container = $(this).parent();
		widgetAdd(container);
		
		return false;
	});
    
    $(document).on('click', '.widget-remove', function() {
		
		if (!confirm('Are you sure to remove selected row?'))
			return false;
		
		var row = $(this).parent().parent();
		var widget = row.parent().parent();
        
		row.fadeOut({
			complete:function() {
				row.remove();
				widgetLimit(widget);
			}
		});
		return false;
	});	
    
    $(document).on('click', '.widget-sort-down', function() {
		var source = $(this).parent().parent();
		var target = source.next();
		
		var sourceId = source.attr('id');
		if (!sourceId) {
			sourceId = uniqid();
			source.attr('id', sourceId);
		}
		
		var targetId = target.attr('id');
		if (!targetId) {
			targetId = uniqid();
			target.attr('id', targetId);
		}
		
		$("#" + sourceId).swap({  
            target: targetId,
            opacity: "0.5",
            speed: 500,
            callback: function() {
                target.insertBefore(source); 
				source.removeAttr('style');
				target.removeAttr('style');
				ckeditorReset();
                widgetIdx();
            }
        }); 
		
		return false;
	});
    
    $(document).on('click', '.widget-sort-up', function() {
		
		var source = $(this).parent().parent();
		var target = source.prev();
		
		var sourceId = source.attr('id');
		if (!sourceId) {
			sourceId = uniqid();
			source.attr('id', sourceId);
		}
		
		var targetId = target.attr('id');
		if (!targetId) {
			targetId = uniqid();
			target.attr('id', targetId);
		}
		
		$("#" + sourceId).swap({  
            target: targetId,
            opacity: "0.5",
            speed: 500,
            callback: function() {
                target.insertAfter(source); 
				source.removeAttr('style');
				target.removeAttr('style');
				ckeditorReset();
                widgetIdx();
            }  
        }); 
		
		return false;
	});
});

$(document).on('change','.title',function() {
	if ($(this).attr('lang')) { console.log('permalink');
		$('input.permalink[lang=' + $(this).attr('lang') + ']').val(slug($(this).val()));
		$('input[origin=meta_title][lang=' + $(this).attr('lang') + ']').val($(this).val());
	} else {
		$('input.permalink').val(slug($(this).val()));
		$('input[origin=meta_title]').val($(this).val());
	}
});
