import jQuery from "jquery";
import popup from './libs/popup.js'
import '/node_modules/select2/dist/css/select2.css';
import select2 from 'select2';
import 'bootstrap-datepicker';
import header from "./libs/header.js";
import responsiveImage from './libs/responsive-images.js';
import animatingScroll from './libs/animatingScroll.js';
import html2canvas from "html2canvas";

// window.$ = $
window.$ = window.jQuery = jQuery;
window.html2canvas = html2canvas;

const responsive = responsiveImage($)

document.addEventListener("DOMContentLoaded", () => {
  popup($).closeGeneral()
  select2()
  $('.select2').select2({
    width: '100%'
  });
  header($).init()
  animatingScroll().animating(".animating-scroll");
  const elemBanner = $('.banner-middle img, .contact-highlight .bg img, .banner-homepage figure img , .tema .bg img, .visi figure img, .popup-login figure img ');
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

  // eye password
  const passwordField = document.getElementById("password");
  const togglePassword = document.querySelector(".password .icon");

  togglePassword.addEventListener("click", function () {
    if (passwordField.type === "password") {
      passwordField.type = "text";
      togglePassword.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 18" fill="none">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M11 6.75C9.755 6.75 8.75 7.755 8.75 9C8.75 10.245 9.755 11.25 11 11.25C12.245 11.25 13.25 10.245 13.25 9C13.25 7.755 12.245 6.75 11 6.75ZM7.25 9C7.25 6.92657 8.92657 5.25 11 5.25C13.0734 5.25 14.75 6.92657 14.75 9C14.75 11.0734 13.0734 12.75 11 12.75C8.92657 12.75 7.25 11.0734 7.25 9Z" fill="#111111"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M1.28282 6.27342C3.69299 2.94267 7.19618 0.969971 11.0001 0.969971C14.8042 0.969971 18.3075 2.94286 20.7177 6.27392C21.2793 7.0479 21.5351 8.0421 21.5351 8.995C21.5351 9.948 21.2792 10.9424 20.7174 11.7165C18.3072 15.0473 14.804 17.02 11.0001 17.02C7.19599 17.02 3.69264 15.0471 1.28246 11.716C0.720898 10.942 0.465088 9.9478 0.465088 8.995C0.465088 8.0419 0.720998 7.0475 1.28282 6.27342ZM11.0001 2.46997C7.74418 2.46997 4.66753 4.15436 2.49771 7.1532L2.497 7.1542C2.15906 7.6197 1.96509 8.2866 1.96509 8.995C1.96509 9.7033 2.15906 10.3703 2.497 10.8357L2.49771 10.8367C4.66753 13.8356 7.74418 15.52 11.0001 15.52C14.256 15.52 17.3326 13.8356 19.5025 10.8367L19.5032 10.8357C19.8411 10.3703 20.0351 9.7033 20.0351 8.995C20.0351 8.2866 19.8411 7.6197 19.5032 7.1542L19.5025 7.1532C17.3326 4.15436 14.256 2.46997 11.0001 2.46997Z" fill="#111111"/>
        </svg>
      `;
    } else {
      passwordField.type = "password";
      togglePassword.innerHTML = `
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M2.28282 9.27342C4.69299 5.94267 8.19618 3.96997 12.0001 3.96997C13.3516 3.96997 14.6696 4.21968 15.9155 4.69366C16.3027 4.84093 16.4971 5.27417 16.3498 5.66131C16.2026 6.04846 15.7693 6.24292 15.3822 6.09564C14.3025 5.68491 13.165 5.46997 12.0001 5.46997C8.74418 5.46997 5.66753 7.15436 3.49771 10.1532L3.49699 10.1542C3.15906 10.6197 2.96509 11.2866 2.96509 11.995C2.96509 12.7033 3.15906 13.3703 3.49699 13.8357L3.49771 13.8367C3.92875 14.4325 4.39582 14.9764 4.89281 15.4654C5.18805 15.7559 5.19187 16.2308 4.90134 16.526C4.61081 16.8213 4.13596 16.8251 3.84072 16.5346C3.28231 15.9851 2.76097 15.3774 2.28246 14.716C1.72089 13.942 1.46509 12.9478 1.46509 11.995C1.46509 11.0419 1.721 10.0475 2.28282 9.27342ZM18.773 7.18838C19.0535 6.88361 19.528 6.86393 19.8328 7.14444C20.5155 7.77278 21.147 8.48525 21.7177 9.27392C22.2793 10.0479 22.5351 11.0421 22.5351 11.995C22.5351 12.948 22.2791 13.9424 21.7173 14.7165C19.3072 18.0473 15.804 20.02 12.0001 20.02C10.5115 20.02 9.06389 19.717 7.70857 19.1455C7.32691 18.9846 7.14798 18.5447 7.30893 18.163C7.46988 17.7813 7.90976 17.6024 8.29142 17.7634C9.46758 18.2594 10.7173 18.52 12.0001 18.52C15.256 18.52 18.3326 16.8356 20.5024 13.8367L20.5032 13.8357C20.8411 13.3703 21.0351 12.7033 21.0351 11.995C21.0351 11.2866 20.8411 10.6197 20.5032 10.1542L20.5024 10.1532C19.9884 9.44277 19.4231 8.80602 18.817 8.24813C18.5122 7.96762 18.4925 7.49316 18.773 7.18838Z" fill="black"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M12 9.75C10.755 9.75 9.75 10.755 9.75 12C9.75 12.5484 9.94405 13.0481 10.2674 13.4375C10.532 13.7562 10.4881 14.229 10.1694 14.4936C9.85076 14.7582 9.37792 14.7144 9.11332 14.3957C8.57407 13.7462 8.25 12.9102 8.25 12C8.25 9.92657 9.92657 8.25 12 8.25C13.0215 8.25 13.9486 8.658 14.6243 9.31951C14.9203 9.60929 14.9253 10.0841 14.6355 10.3801C14.3457 10.6761 13.8709 10.6811 13.5749 10.3913C13.1691 9.99399 12.6147 9.75 12 9.75ZM15 11.25C15.4142 11.25 15.75 11.5858 15.75 12C15.75 14.0734 14.0734 15.75 12 15.75C11.5858 15.75 11.25 15.4142 11.25 15C11.25 14.5858 11.5858 14.25 12 14.25C13.245 14.25 14.25 13.245 14.25 12C14.25 11.5858 14.5858 11.25 15 11.25Z" fill="black"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M22.5533 2.19366C22.8329 2.49926 22.8119 2.97366 22.5063 3.25328L2.5063 21.5533C2.2007 21.8329 1.7263 21.8118 1.44668 21.5062C1.16706 21.2006 1.18812 20.7262 1.49371 20.4466L21.4937 2.14663C21.7993 1.86701 22.2737 1.88807 22.5533 2.19366Z" fill="black"/>
        </svg>
      `;
    }
  });
  //  End Password

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
