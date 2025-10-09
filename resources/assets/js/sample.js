import $ from 'jquery' //import jquery module
import Swiper from 'swiper/bundle';
// import responsiveImage from './libs/responsive-images.js';
import 'slick-carousel';
import 'slick-carousel/slick/slick.css';
import 'jquery-ui-bundle';
import 'jquery-ui-bundle/jquery-ui.css';

// const responsive = responsiveImage($)
const home = {};

home.herobannerFull = () => {
  let options = {};
  if ($(".herobanner-full.swiper-full .swiper-wrapper .swiper-slide").length == 1) {
    options = {
      loop: false,
    }
    $('.herobanner-full.swiper-full .swiper-arrow').css('display', 'none');
  } else {
    options = {
      loop: true,
      speed: 1000,
      autoResize: true,
      effect: "fade",
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true
      },
      breakpoints: {
        320: {
          navigation: { enabled: false },
        },
        768: {
          navigation: { enabled: true },
        },
      },
    }
  }

  const swiper = new Swiper('.herobanner-full.swiper-full.swiper', options);

  swiper.on('slideChange', function () {
    if ($(`[data-swiper-slide-index="${this.realIndex}"]`).find("video").length) {
      swiper.autoplay.paused = true

    } else {
      swiper.autoplay.running = true
      swiper.autoplay.paused = false
    }
  })

}

home.historyYear = () => {

  $('.slider-year').slick({
    arrows: true,
    // autoplay: true,
    autoplaySpeed: 3000,
    speed: 700,
    dots: false,
    infinite: true,
    centerMode: true,
    slidesToShow: 7,
    centerPadding: '0',
    focusOnSelect: true,
    prevArrow: `
			<div class="arrow-prev">
				<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
					<path d="M30 36L18 24L30 12" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
		`,
    nextArrow: `
			<div class="arrow-next">
				<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" fill="none">
					<path d="M20 12L32 24L20 36" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
		`,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 5
        }
      }, {
        breakpoint: 768,
        settings: {
          slidesToShow: 3
        }
      },
    ]
  });

  $('.slider-inyear > div .slider-inyear__slider--list').slick({
    arrows: false,
    autoplay: false,
    autoplaySpeed: 3000,
    speed: 700,
    dots: false,
    infinite: false,
    slidesToShow: 4,
    responsive: [
      {
        breakpoint: 1280,
        settings: {
          slidesToShow: 3.5
        }
      }, {
        breakpoint: 1023,
        settings: {
          slidesToShow: 2.9
        }
      }, {
        breakpoint: 767,
        settings: {
          slidesToShow: 1.4
        }
      }
    ]
  });

  // On before slide change
  $('.slider-year').on('afterChange', function (event, slick, currentSlide, nextSlide) {
    const id = $(this).find(".slick-slide[data-slick-index=" + currentSlide + "] li").attr('id');
    $(".slider-inyear > div[data-slide=" + id + "]").addClass('active').find('.slider-inyear__slider--list').slick("getSlick").refresh();
    $(".slider-inyear > div:not([data-slide=" + id + "])").removeClass('active');
  });
}

home.init = function () {
  home.herobannerFull()
}

home.init();

window.onload = () => {
  home.historyYear()
}
