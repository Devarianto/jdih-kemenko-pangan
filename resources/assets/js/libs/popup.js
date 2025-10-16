export default ($) => ({
  openPopup(element) {
    const elementPopup = $(element);
    elementPopup.addClass('popup__show');
    if (!elementPopup.hasClass('scroll')) {
      $('body').css({ 'overflow': 'hidden' })
    }
    
  },
  closePopup(element) {
    const elementPopup = $(element);
    elementPopup.removeClass('popup__show');
    $('body').css({ 'overflow': 'auto' })
  },
  closeGeneral() {
    $('.popup__overlay').on('click', function (e) {
      $(this).parent().removeClass('popup__show')
      $('body').css({ 'overflow': 'auto' })
       $('.popup__content').each(function () {
        let iframe = $(this).find('iframe');
        iframe.each(function () {
          $(this).attr('src','');
          return false;
        });
      });
    })
    $('.popup__close').on('click', function (e) {
      $(this).parents('.popup').removeClass('popup__show')
      $('body').css({ 'overflow': 'auto' })
      $('.popup__content').each(function () {
        let iframe = $(this).find('iframe');
        iframe.each(function () {
          $(this).attr('src','');
          return false;
        });
      });
    })
  },
  init() {
    this.closeGeneral()
  }
})
