export default($) => ({
  show(element){
    element.wrapper.addClass('active')
    element.content.slideDown(300)
  },
  hide(element){
    element.wrapper.removeClass('active')
    element.content.slideUp(300)
  },
  init(element){
    const this_ = this
    const parent = element.parent()

    //first init
    $(element).each(function(){
      if($(this).hasClass('active'))
        this_.show({
          wrapper: $(this),
          content: $(this).find('.content')
        })
    })

    //add listener click
    element.find('.head').on('click',function(e){
      e.preventDefault()
      const accordion = $(this).parent()
      const activeAccordion = accordion.parent().find('.active')

      if(activeAccordion.length && accordion.hasClass('active')){
        this_.hide({
          wrapper: accordion,
          content: accordion.find('.content')
        })
      }else{
        this_.show({
          wrapper: accordion,
          content: accordion.find('.content')
        })
        this_.hide({
          wrapper: activeAccordion,
          content: activeAccordion.find('.content')
        })
      }
    })
  }
})