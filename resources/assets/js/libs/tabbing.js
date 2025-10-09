export default($) => ({
  show(element){
    element.parent().find('a').removeClass('active')
    element.addClass('active')
    element.parents('.wrap-tab').find('.content-tab').slideUp(300)
    element.parents('.wrap-tab').find(element.attr('data-tab')).slideDown(300)
  },
  init(element){
    const this_ = this
    const parent = element
    const nav = element.find('.nav-tab a')

    //first init
    nav.each(function(){
      if($(this).hasClass('active'))
        this_.show($(this))
    })

    //add listener click
    nav.on('click',function(e){
      e.preventDefault()

      if(!$(this).hasClass('active') && !$(this).hasClass('no-click')){
        this_.show($(this))
        const offsetScroll = $(this).position().left + $(this).parent().scrollLeft() - 16
        $(this).parent().animate({
            scrollLeft: offsetScroll + 'px'
        },200)
      }
    })
  }
})
