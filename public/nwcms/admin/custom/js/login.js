$(document).ready(function(){
    $('.input-group input').on('focus', function(){
        $(this).closest('.input-group').addClass('focus');
    });
    $('.input-group input').on('blur', function(){
        if  ( $(this).val() === '') {
            $(this).closest('.input-group').removeClass('focus');
        }
    });
    $('.input-group input').each(function () {
        if ($(this).val() !== '') {
            $(this).closest('.input-group').addClass('focus');
        }
    });
    $('.input-group').on('focusin focusout', 'input', function () {
        $(this).closest('.input-group').toggleClass('focus', this.value !== '');
    });
});