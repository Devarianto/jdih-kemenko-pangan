export default ($) => ({
  floatingMenu() {
    let header = $("header"),
      fnc = {},
      ww = $(window).width()


    fnc.runfnc = function () {
      let topmin = 0;
      if ($(window).scrollTop() > topmin) {
        $("header").addClass("floating");
      } else {
        $("header").removeClass("floating");
      }
    };
    $(window).scroll(function () {
      fnc.runfnc();
    });
    fnc.runfnc();
  },
  burgerMenu() {
    if ($(window).width() < 1200) {
      const elem = $('header .toggle-menu');
      elem.on('click', function () {
        if (!$(this).hasClass('active')) {
          $(this).parents().find('.menu-mobile').fadeIn();
          $(this).addClass('active');
          $('header').addClass('floating show-burger');
          $('body').css('overflow', 'hidden');
        } else {
          $(this).parents().find('.menu-mobile').fadeOut();
          $(this).removeClass('active');
          $('header').removeClass('show-burger');
          $('body').css('overflow', 'auto');
        }
      });

      $('header i').on('click', function (e) {
        e.preventDefault();
        if (!$(this).parent().hasClass('show')) {
          $(this).parent().addClass('show');
          $(this).parent().find('.child').slideDown();
          $('header nav ul > li.have-child i').not($(this)).parent().removeClass('show').find('.child').slideUp();
        } else {
          $(this).parent().removeClass('show');
          $(this).parent().find('.child').slideUp();
        }
      });
    }
  },
  userButton() {
    $('.after-login > a').on('click', function (e) {
      e.preventDefault()
      if (!$(this).hasClass('active-drop')) {
        $(this).addClass('active-drop')
        $(this).parent().find('.after-login__drop').stop().slideDown()
      } else {
        $(this).removeClass('active-drop')
        $(this).parent().find('.after-login__drop').stop().slideUp()

      }

    })
  },
  init() {
    this.floatingMenu()
    this.burgerMenu()
    this.userButton()
  }
})
