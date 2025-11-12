import jQuery from "jquery";
import popup from './libs/popup.js'
import '/node_modules/select2/dist/css/select2.css';
import select2 from 'select2';
import 'bootstrap-datepicker';
import header from "./libs/header.js";
import responsiveImage from './libs/responsive-images.js';
import animatingScroll from './libs/animatingScroll.js';

// window.$ = $
window.$ = window.jQuery = jQuery;
const responsive = responsiveImage($)

document.addEventListener("DOMContentLoaded", () => {
  popup($).closeGeneral()
  select2()
  $('.select2').select2({
    width: '100%'
  });
  header($).init()
  animatingScroll().animating(".animating-scroll");
  const elemBanner = $('.banner-middle img, .contact-highlight .bg img, .banner-homepage figure img , .tema .bg img, .visi figure img');
  responsive.init(elemBanner, {
    type: 'image'
  })
  $('.wrap-filter a').on('click', function (e) {
    e.preventDefault();
    e.stopPropagation(); // jangan biarkan event menjalar ke document
    $(this).next('.filter').fadeToggle();
  });

  $('.filter__close').on('click', function (e) {
    e.stopPropagation();
    $(this).closest('.filter').fadeOut();
  });

  // klik di dalam filter tidak menutupnya
  $('.filter').on('click', function (e) {
    e.stopPropagation();
  });

  // klik di luar filter akan menutup semua filter yang terbuka
  $(document).on('click', function () {
    $('.filter').fadeOut();
  });

  if ($('.detail-pages, .dashboard, .misc').length) {
    $("header").addClass("white");
  }
  if ($('.with-other').length) {
    $("footer").addClass("gray");
  }
  $('.dashboard__left nav').each(function () {
    const titleActive = $(this).find('li a.active').text()
    let append = $(this).find('ul')
    $(`<span class='trigger-dropdown'>
        <svg xmlns="http://www.w3.org/2000/svg" width="23" height="24" viewBox="0 0 23 24" fill="none">
          <path d="M22.4397 14.6049L21.2603 13.4341C20.9064 13.0829 20.4051 12.878 19.9038 12.878C19.3731 12.878 18.9013 13.0829 18.5474 13.4341L12.0603 19.9024C11.8833 20.078 11.7949 20.2829 11.7949 20.5171V23.122C11.7949 23.6195 12.1782 24 12.6795 24H15.3038C15.5397 24 15.7756 23.9122 15.9231 23.7366L22.4397 17.2976C22.7936 16.9463 23 16.4488 23 15.9512C23 15.4537 22.7936 14.9561 22.4397 14.6049ZM19.9038 14.6341C19.9333 14.6341 19.9923 14.6341 20.0218 14.6927L21.2013 15.8634C21.2308 15.8927 21.2603 15.9512 21.2603 15.9805C21.2603 16.0098 21.2603 16.0683 21.2013 16.0976L20.4641 16.8293L19.0782 15.4537L19.8154 14.722C19.8154 14.6341 19.8744 14.6341 19.9038 14.6341ZM14.95 22.2439H13.5641V20.8683L17.7808 16.6829L19.1667 18.0585L14.95 22.2439ZM9.14103 21.0732H4.42308C2.56538 21.0732 1.76923 20.2829 1.76923 18.439V4.39024C1.76923 2.54634 2.56538 1.7561 4.42308 1.7561H10.6154V4.39024C10.6154 7.22927 12.1782 8.78049 15.0385 8.78049H17.6923V10.2439C17.6923 10.7415 18.0756 11.122 18.5769 11.122C19.0782 11.122 19.4615 10.7415 19.4615 10.2439V7.90244C19.4615 7.66829 19.3731 7.43415 19.1962 7.2878L12.1192 0.263415C11.9718 0.0878049 11.7359 0 11.5 0H4.42308C1.56282 0 0 1.55122 0 4.39024V18.439C0 21.278 1.56282 22.8293 4.42308 22.8293H9.14103C9.64231 22.8293 10.0256 22.4488 10.0256 21.9512C10.0256 21.4537 9.64231 21.0732 9.14103 21.0732ZM12.3846 4.39024V2.98537L16.4538 7.02439H15.0385C13.1808 7.02439 12.3846 6.23415 12.3846 4.39024ZM5.60256 10.5366C5.10128 10.5366 4.71795 10.9171 4.71795 11.4146C4.71795 11.9122 5.10128 12.2927 5.60256 12.2927H13.859C14.3603 12.2927 14.7436 11.9122 14.7436 11.4146C14.7436 10.9171 14.3603 10.5366 13.859 10.5366H5.60256ZM10.3205 15.2195H5.60256C5.10128 15.2195 4.71795 15.6 4.71795 16.0976C4.71795 16.5951 5.10128 16.9756 5.60256 16.9756H10.3205C10.8218 16.9756 11.2051 16.5951 11.2051 16.0976C11.2051 15.6 10.8218 15.2195 10.3205 15.2195Z" fill="white"/>
        </svg>
        ${titleActive}
      </span>`).insertBefore(append);
  })

  $(document).on("click", ".trigger-dropdown", function () {
    console.log('hore');

    $(this).next().slideToggle()
    $(this).toggleClass('active-drop')
  })

  $(document).on("click", function (event) {
    if ($(window).width() < 768) {
      if (!$(event.target).closest(".dashboard__left .trigger-dropdown").length) {
        $(".dashboard__left ul").slideUp();
        $(".dashboard__left .trigger-dropdown").removeClass("active-drop");
      }
    }
  });
  $('.right-header__lang >img').on('click', function () {
    $(this).next('.drop-language').slideToggle()
  })



})

window.openPopup = (id) => {
  popup($).openPopup(id)
}
window.closePopup = (id) => {
  popup($).closePopup(id)
}
