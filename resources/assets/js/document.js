import $ from 'jquery'; //import jquery module
import Swiper  from 'swiper/bundle';

const doc = {};
doc.tabbing = () => {
  const $links = $('.box-detail-page__pdf nav ul li a');
  const $tabs = $('.box-detail-page__pdf .content-tab');

  $links.on('click', function(e){
    e.preventDefault();
    const tab = $(this).data('tab'); // ambil dari data-tab, bukan href
    if (!tab) return;
    $links.removeClass('active');
    $(this).addClass('active');
    $tabs.stop(true, true).fadeOut();
    $tabs.filter('[data-tab="'+tab+'"]').fadeIn();
  });

  // Tampilkan tab yang sudah punya class .active; kalau tidak ada, pakai yang pertama
  const $activeLink = $links.filter('.active').first();
  const $initial = $activeLink.length ? $activeLink : $links.first();
  const initTab = $initial.data('tab');

  $tabs.hide();
  if (initTab) {
    $tabs.filter('[data-tab="'+initTab+'"]').fadeIn();
  }
}
doc.sliderDetail = () => {
   const swiper = new Swiper('.slider-caption.swiper', {
    loop: true,
    slidesPerView: 1,
    navigation: {
      nextEl: ".slider-caption__utils .swiper-next",
      prevEl: ".slider-caption__utils .swiper-prev",
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
      dynamicBullets: true, // Enable dynamic bullets
      dynamicMainBullets:5,
    },
  });
  const totalSlides = $('.slider-caption.with-pagination .swiper-slide').length;
  const $current = $('.current-slide');
  const $total = $('.total-slide');
  $total.text(totalSlides); // Set total slides on init
  const swiper2 = new Swiper('.slider-caption.with-pagination', {
    loop: true,
    slidesPerView: 1,
    navigation: {
      nextEl: ".slider-caption__utils .swiper-next",
      prevEl: ".slider-caption__utils .swiper-prev",
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
      dynamicBullets: true, // Enable dynamic bullets
      dynamicMainBullets:5,
    },
    on: {
      init: function () {
        $current.text(1);
      },
      slideChange: function () {
        $current.text(this.realIndex + 1);
      }
    }
  });
}

doc.sliderPopup = () => {
  const sliderThumbnail = new Swiper('.photo-slider-thumbs.swiper', {
    slidesPerView: 5,
    freeMode: true,
    spaceBetween:16,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    breakpoints: {
      1023: {
        slidesPerView:6,
      }
    },
  });

  const slider = new Swiper('.swiper.photo-slider', {
    slidesPerView: 1,
    thumbs: {
      swiper: sliderThumbnail
    }
  });
}
doc.playVideo = function () {
  $(".listing-galeri__item .icon-play").on('click',function(){
    openPopup('#popup-video')
    let container = $('#popup-video');
    let iframe = container.find(".wrap-video iframe");
    let videoUrl = $(this).parents('.listing-galeri__item').data("video") + "?autoplay=1";
    // Set src baru
    iframe.attr("src", videoUrl);
  });
}
doc.init = function () {
  this.tabbing()
  this.sliderDetail()
  this.sliderPopup()
  this.playVideo()
}

doc.init();