export default ($) => ({
  floatingMenu() {
    let header = $("header"),
      fnc = {},
      ww = $(window).width()


    fnc.runfnc = function () {
      let topmin = 0;
      let hasBanner = $('.banner-middle').length > 0 || $('.banner-homepage').length > 0 || $('.banner-detail').length > 0 || $('.banner-content').length > 0;
      if (!hasBanner) {
        $("header").addClass("floating");
      } else if ($(window).scrollTop() > topmin) {
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
  dropdownMenu() {
    const $haveChild = $('header nav ul > li.have-child');

    const checkAlign = ($li) => {
      const $child = $li.children('.child');
      if (!$child.length) return;
      $li.removeClass('align-left align-right');
      const offset = $li.offset();
      if (!offset) return;
      const windowWidth = $(window).width();
      const leftPos = offset.left;
      
      if (leftPos < 280) {
        $li.addClass('align-left');
      } else if (windowWidth - leftPos < 380) {
        $li.addClass('align-right');
      }
    };

    $haveChild.each(function () {
      checkAlign($(this));
    });

    $(window).on('resize', function () {
      $haveChild.each(function () {
        checkAlign($(this));
      });
    });

    $haveChild.children('.nav-parent-link, > a').on('click', function (e) {
      if ($(window).width() >= 1200) {
        const $li = $(this).parent('li.have-child');
        const isOpen = $li.hasClass('is-open');

        e.preventDefault();
        e.stopPropagation();

        $haveChild.not($li).removeClass('is-open');

        if (isOpen) {
          $li.removeClass('is-open');
        } else {
          checkAlign($li);
          $li.addClass('is-open');
        }
      }
    });

    $('header .child').on('click', function (e) {
      e.stopPropagation();
    });

    $(document).on('click', function () {
      $haveChild.removeClass('is-open');
    });

    $(document).on('keydown', function (e) {
      if (e.key === 'Escape' || e.keyCode === 27) {
        $haveChild.removeClass('is-open');
      }
    });
  },
  init() {
    this.floatingMenu()
    this.burgerMenu()
    this.userButton()
    this.dropdownMenu()
  }
})
