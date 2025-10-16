export default ($) => ({
  floatingMenu() {
    let header = $("header"),
      fnc = {},
      ww = $(window).width();

    fnc.runfnc = function () {
      let topmin = 0;
      if ($(window).scrollTop() > topmin) {
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
  init(){
    this.floatingMenu()
  }
})