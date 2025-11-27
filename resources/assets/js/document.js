import $ from 'jquery'; //import jquery module
import Swiper from 'swiper/bundle';
import accordion from './libs/accordion-base-import.js';

const doc = {};
doc.tabbing = () => {
  const $links = $('.box-detail-page__pdf nav ul li a');
  const $tabs = $('.box-detail-page__pdf .content-tab');

  $links.on('click', function (e) {
    e.preventDefault();
    const tab = $(this).data('tab'); // ambil dari data-tab, bukan href
    if (!tab) return;
    $links.removeClass('active');
    $(this).addClass('active');
    $tabs.stop(true, true).fadeOut();
    $tabs.filter('[data-tab="' + tab + '"]').fadeIn();
  });

  // Tampilkan tab yang sudah punya class .active; kalau tidak ada, pakai yang pertama
  const $activeLink = $links.filter('.active').first();
  const $initial = $activeLink.length ? $activeLink : $links.first();
  const initTab = $initial.data('tab');

  $tabs.hide();
  if (initTab) {
    $tabs.filter('[data-tab="' + initTab + '"]').fadeIn();
  }
}
doc.sliderDetail = () => {

  const $current = $('.current-slide');
  const $total = $('.total-slide');

  const swiper = new Swiper('.slider-caption.with-pagination', {
    loop: true,
    slidesPerView: 1,
    navigation: {
      nextEl: ".slider-caption__utils .swiper-next",
      prevEl: ".slider-caption__utils .swiper-prev",
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
      dynamicBullets: true,
      dynamicMainBullets: 5,
    },

    on: {
      init: function () {
        const originalSlides = this.slides.filter(
          s => !s.classList.contains('swiper-slide-duplicate')
        ).length;

        $total.text(originalSlides);
        $current.text(1);
      },

      // 🎯 Update saat drag / swipe / momentum
      realIndexChange: function () {
        $current.text(this.realIndex + 1);
      },

      // 🎯 Extra fallback untuk loop (sangat stabil)
      transitionEnd: function () {
        $current.text(this.realIndex + 1);
      }
    }
  });

};

doc.playVideo = function () {
  $(".listing-galeri__item .icon-play").on('click', function () {
    openPopup('#popup-video')
    let container = $('#popup-video');
    let iframe = container.find(".wrap-video iframe");
    let videoUrl = $(this).parents('.listing-galeri__item').data("video") + "?autoplay=1";
    // Set src baru
    iframe.attr("src", videoUrl);
  });
}

doc.sliderPopup = (target) => {
  const sliderThumbnail = new Swiper(target + ' .photo-slider-thumbs.swiper', {
    slidesPerView: 3.5,
    freeMode: true,
    spaceBetween: 16,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    breakpoints: {
      767: {
        slidesPerView: 5,
      },
      1023: {
        slidesPerView: 6,
      }
    },
  });

  const slider = new Swiper(target + ' .swiper.photo-slider', {
    slidesPerView: 1,
    thumbs: {
      swiper: sliderThumbnail
    }
  });
}

doc.popupSliderGaleri = function () {
  $(document).on('click', '.listing-galeri__item.photo', function () {
    let target = $(this).data('target'),
      popupId = $('#popup-photo');
    popupId.find('.wrap-slider').removeClass('active').hide()
    $('.wrap-slider .swiper.photo-slider').each(function () {
      if (this.swiper && typeof this.swiper.destroy === 'function') {
        this.swiper.destroy(true, true);
      }
    });
    popupId.find(target).addClass('active').show()
    openPopup('#popup-photo')
    setTimeout(() => {
      doc.sliderPopup(target)
    }, 80);
  });
}
doc.init = function () {
  this.tabbing()
  this.sliderDetail()
  this.playVideo()
  this.popupSliderGaleri()
  accordion.accordion('.accordion')
}

doc.init();
