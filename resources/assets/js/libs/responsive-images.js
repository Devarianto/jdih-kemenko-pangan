export default ($) => ({
  supportsWebp() {
    const elem = document.createElement('canvas');
    if (!!(elem.getContext && elem.getContext('2d'))) {
      // was able or not to get WebP representation
      return elem.toDataURL('image/webp').indexOf('data:image/webp') == 0;
    }
    // very old browser like IE 8, canvas not supported
    return false;
  },
  init(elem, e) {
    const webpSupport = this.supportsWebp(),
      ext = webpSupport ? "-webp" : "",
      this_ = this

    let etype = e.type
    if (etype === undefined) {
      etype = "background";
    }
    const windowWidth = $(window).width();
    elem.each(function() {
      let flag = false
      let imagesUrl = ''
      if (windowWidth >= 940 && $(this).attr('data-has-load') != 'large') {
        imagesUrl = $(this).attr('data-img-large' + ext);
        if (imagesUrl == undefined || imagesUrl == "") {
          imagesUrl = $(this).attr('data-img-large');
        }
        $(this).attr('data-has-load', 'large');
        flag = true;
      } else if (windowWidth < 940 && windowWidth >= 600 && $(this).attr('data-has-load') != 'medium') {
        imagesUrl = $(this).attr('data-img-medium' + ext);
        if (imagesUrl == undefined || imagesUrl == "") {
          imagesUrl = $(this).attr('data-img-medium');
        }
        $(this).attr('data-has-load', 'medium');
        flag = true;
      } else if (windowWidth < 600 && windowWidth >= 0 && $(this).attr('data-has-load') != 'small') {
        imagesUrl = $(this).attr('data-img-small' + ext);
        if (imagesUrl == undefined || imagesUrl == "") {
          imagesUrl = $(this).attr('data-img-small');
        }
        $(this).attr('data-has-load', 'small');
        flag = true;
      }
      if (imagesUrl == undefined) {
        imagesUrl = $(this).attr('data-img-large');
        $(this).attr('data-has-load', 'large');
      }

      if (flag) {
        if (etype == "background") {
          $(this).css('background-image', 'url(' + imagesUrl + ')');
        } else {
          $(this).attr('src', imagesUrl);
        }
      }
    });

    var resizeTimer;

    $(window).resize(function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function() {
        this_.init(elem, e)
      }, 500);
    });
  },
})