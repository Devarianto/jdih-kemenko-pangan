import $ from 'jquery'; //import jquery module
import Swiper from 'swiper/bundle';
import 'slick-carousel';

const home = {};
home.sliderDocument = () => {
  if ($(window).width() > 1024) {
    if ($('.swiper .document__listing--item').length <= 4) {
      $('.document').addClass('disable-arrow')
      return
    }
  }
  const swiper = new Swiper('.document__listing.swiper', {
    loop: true,
    spaceBetween: 24,
    slidesPerView: 1.2,
    slidesOffsetBefore: 0,  // penting: jangan offset dari kiri lagi
    slidesOffsetAfter: 0,
    navigation: {
      nextEl: ".document__title .swiper-next",
      prevEl: ".document__title .swiper-prev",
    },
    autoplay: {
      delay: 6000,
      disableOnInteraction: false,
    },
    breakpoints: {
      767: {
        slidesPerView: 2.2,
      },
      1023: {
        slidesPerView: 3,
      },
      1200: {
        slidesPerView: 4,
      }
    },
  });

}
home.ratingHome = () => {
  if (typeof ratingData === 'undefined') {
    console.warn('ratingData belum didefinisikan!');
    return;
  }

  const total = Object.values(ratingData.breakdown).reduce((a, b) => a + b, 0);

  // Kosongkan elemen target agar tidak duplikat render
  $('#ratingBreakdown').empty();

  // Render bar rating (5 → 1)
  for (let i = 5; i >= 1; i--) {
    const count = ratingData.breakdown[i] || 0;
    const percent = (count / total) * 100;
    const bar = `
      <div class="bar">
        <span>${i}</span>
        <span class="star">★</span>
        <div class="progress">
          <div class="fill" style="width:${percent}%;"></div>
        </div>
      </div>
    `;
    $('#ratingBreakdown').append(bar);
  }

  // Update angka & total
  $('#average').text(ratingData.average.toFixed(1));
  $('#total-reviews').text(`${ratingData.total} ${$('#total-reviews').data('title')}`);

  // Render bintang dinamis
  const renderStars = (avg) => {
    let stars = '';
    const fullStars = Math.floor(avg);
    const hasHalf = avg % 1 >= 0.5;
    const color = getStarColor(avg);

    for (let i = 1; i <= 5; i++) {
      if (i <= fullStars) {
        stars += `<span style="color:${color};">★</span>`;
      } else if (i === fullStars + 1 && hasHalf) {
        stars += `<span style="color:${color}; opacity:0.5;">★</span>`;
      } else {
        stars += `<span style="color:#ddd;">★</span>`;
      }
    }
    return stars;
  };

  // Warna bintang sesuai rating
  const getStarColor = (avg) => {
    if (avg >= 4.5) return '#FFD21E'; // emas terang
    if (avg >= 3.5) return '#FFD21E'; // kuning cerah
    if (avg >= 2.5) return '#FFD21E'; // oranye muda
    if (avg >= 1.5) return '#FFD21E'; // kuning kusam
    return '#999'; // abu-abu
  };

  $('#stars').html(renderStars(ratingData.average));
};

home.sliderLogo = () => {
  if ($(window).width() > 1024) {
    if ($('.logo-slider .swiper-slide').length < 6) {
      $('.logo-slider').addClass('disable')
      return
    }
  } else if ($(window).width() <= 1024) {
    if ($('.logo-slider .swiper-slide').length <= 4) {
      $('.logo-slider').addClass('disable')
      return
    }
  } else {
    if ($('.logo-slider .swiper-slide').length <= 2) {
      $('.logo-slider').addClass('disable')
      return
    }
  }
  const swiper = new Swiper('.logo-slider.swiper', {
    loop: true,
    slidesPerView: 2,
    spaceBetween: 24,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".logo-slider .swiper-next",
      prevEl: ".logo-slider .swiper-prev",
    },
    breakpoints: {
      767: {
        slidesPerView: 4,
        spaceBetween: 24,
        centeredSlides: false,
      },
      1200: {
        slidesPerView:6,
        spaceBetween: 0,
      }
    },
  });
}

home.sliderPopup = () => {
  const sliderThumbnail = new Swiper('.photo-slider-thumbs.swiper', {
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

  const slider = new Swiper('.swiper.photo-slider', {
    slidesPerView: 1,
    thumbs: {
      swiper: sliderThumbnail
    }
  });
}
home.playVideo = function () {
  $(".grid__item .icon-play").on('click', function () {
    openPopup('#popup-video')
    let container = $('#popup-video');
    let iframe = container.find(".wrap-video iframe");
    let videoUrl = $(this).parents('.grid__item').data("video") + "?autoplay=1";
    // Set src baru
    iframe.attr("src", videoUrl);
  });
}
home.sliderTablet = function () {
  if ($(window).width() < 1024) {
    $('.artikel .document__listing').slick({
      variableWidth: true,
      arrows: false,
      dots: false,
      autoplay: true
    })
  }
}
home.temaSlider = function () {
  const temaSwiper = new Swiper('.tema-slider .swiper', {
    slidesPerView: 4,
    spaceBetween: 24,
    navigation: {
      nextEl: ".tema-slider .swiper-button-next",
      prevEl: ".tema-slider .swiper-button-prev",
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 16,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 16,
      },
      1024: {
        slidesPerView: 4,
        spaceBetween: 24,
      }
    }
  });
}
home.init = function () {
  this.sliderDocument()
  this.sliderLogo()
  this.ratingHome()
  this.playVideo()
  this.sliderPopup()
  this.sliderTablet()
  this.temaSlider()
}

home.init();

window.onload = () => {
}
