import $ from 'jquery'; //import jquery module

const document = {};
document.tabbing = () => {
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
document.init = function () {
  this.tabbing()
}

document.init();