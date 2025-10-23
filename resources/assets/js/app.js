import jQuery from "jquery";
import popup  from './libs/popup.js'
import '/node_modules/select2/dist/css/select2.css';
import select2 from 'select2';
import header from "./libs/header.js";
import responsiveImage from './libs/responsive-images.js';
import animatingScroll from './libs/animatingScroll.js';

// window.$ = $
window.$ = window.jQuery = jQuery;
const responsive = responsiveImage($)

document.addEventListener("DOMContentLoaded", () => {
  popup($).closeGeneral()
  select2()
  header($).init()
  animatingScroll().animating(".animating-scroll");
  const elemBanner = $('.banner-middle img');
  responsive.init(elemBanner, {
    type: 'image'
  })
  $('.wrap-filter a').on('click', function(e){
    e.preventDefault();
    e.stopPropagation(); // jangan biarkan event menjalar ke document
    $(this).next('.filter').fadeToggle();
  });

  $('.filter__close').on('click', function(e){
    e.stopPropagation();
    $(this).closest('.filter').fadeOut();
  });

  // klik di dalam filter tidak menutupnya
  $('.filter').on('click', function(e){
    e.stopPropagation();
  });

  // klik di luar filter akan menutup semua filter yang terbuka
  $(document).on('click', function(){
    $('.filter').fadeOut();
  });

  if ($('.detail-pages, .dashboard, .misc').length) {
    $("header").addClass("white"); 
  }
  if ($('.with-other').length) {
    $("footer").addClass("gray"); 
  }
})

window.openPopup = (id) => {
	popup($).openPopup(id)
}
window.closePopup = (id) => {
	popup($).closePopup(id)
}
